<?php
  
namespace App\Http\Controllers;
   
use App\Models\Company;
use App\Models\Address;
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
        $companies = Company::latest()->paginate(5);
    
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
        // $request->validate([
        //     'name' => 'required',
        //     'url' => 'required',
        // ]);             
        
        // for all form input same table use this
        //Company::create($request->all());

        // two tables insert same time
        $comp = new Company();
        $comp->name = $request->name;
        $comp->url = $request->url;
        $comp->save();
        
        $location = new Address();
        $location->company_id = $comp->id;
        $location->address = $request->address;
        $location->save();
     
        return redirect()->route('companies.index')
                        ->with('success','Company created successfully.');
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