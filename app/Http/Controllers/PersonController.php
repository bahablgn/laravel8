<?php
  
namespace App\Http\Controllers;
   
use App\Models\Person;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
  
class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::latest()->paginate(5);       
        $company = Company::with('person');
        return view('people.index',compact('people','company'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = DB::table('companies')->pluck("name","id");
        return view('people.create', compact('companies'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'title' => 'required',
            'email' => 'required',
            'phone' => 'required',      
        ]);
    
        Person::create($request->all());
     
        return redirect()->route('people.index')
                        ->with('success','Person created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        $company = Company::with('person')->find($person->company_id);
        return view('people.show',compact('person','company'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $companies = DB::table('companies')->pluck("name","id");
        $company = Company::with('person')->find($person->company_id);
        return view('people.edit',compact('person','company', 'companies'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'title' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
    
        $person->update($request->all());
    
        return redirect()->route('people.index')
                        ->with('success','Person updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
    
        return redirect()->route('people.index')
                        ->with('success','Person deleted successfully');
    }

    
}