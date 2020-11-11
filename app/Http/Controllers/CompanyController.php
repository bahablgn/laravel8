<?php
  
namespace App\Http\Controllers;
   
use App\Models\Company;
use App\Models\Address;
use App\Models\Website;
use Illuminate\Http\Request;
  
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$companies = Company::latest()->paginate(5);
        $companies = Company::with('addresses')->get(); 

    
        return view('companies.index',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //for validation
        $request->validate([
            'name' => 'required',
            'url' => 'required|url',
            'address' => 'required',
        ]);             
        
        // for all form input same table use this
        //Company::create($request->all());

        // two tables insert same time
        $company = new Company();
        $company->name = $request->name;
        $company->url = $request->url;
        $company->save();
        
        $address = new Address();
        $address->company_id = $company->id;
        $address->address = $request->address;
        $address->save();

        $htmlFlag = false;

        function thumbalizr($url, $options = array()) {
            $embed_key = 'E97Iqtb9sCrgGwybROF5xNeNj'; # replace it with you Embed API key
            $secret = '701liukCVOZZcg2s4N13cgW6p3tz9'; # replace it with your Secret
            
            $query = 'url=' . urlencode($url);
            
            foreach($options as $key => $value) { 
                $query .= '&' . trim($key) . '=' . urlencode(trim($value)); 
                
            }            
            
            $token = md5($query . $secret);            
        
            return "https://api.thumbalizr.com/api/v1/embed/$embed_key/$token/?$query";
        }

        $_html = file_get_contents($company->url);
        //echo $html;
        if(!empty($_html)){
            $html = htmlentities($_html);
            if(!empty($html)){
                $website = new Website();
                $website->company_id = $company->id;
                $website->html = $html;
                
                $thumbImg = thumbalizr($company->url);
                if($thumbImg){
                    $website->thumbnail = $thumbImg;
                    $website->save();
                    $htmlFlag = true;
                }
                else {
                    $website->save();
                    $htmlFlag = true;
                }            
                
            }         
            
        }

        if($htmlFlag){
            return redirect()->route('companies.index')
                ->with('success','Company created and website HTML content stored');
        }
        else{
            return redirect()->route('companies.index')
                ->with('success','Company created successfully but website HTML content permission denied');
        }    
        
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show',compact('company'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit',compact('company'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {       
        $company->update($request->all());

        $company->addresses[0]->update([
            'address' => $request['address']          
        ]);    
    
        return redirect()->route('companies.index')
                        ->with('success','Company updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
    
        return redirect()->route('companies.index')
                        ->with('success','Company deleted successfully');
    }
}