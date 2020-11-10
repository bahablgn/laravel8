<?php
  
namespace App\Http\Controllers;
   
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
  
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
     
    public function index(Employee $employee)
    {
        //$employees = Employee::latest()->paginate(5);     
        $employees = Employee::with('company')->get(); 

        return view('employees.index', compact('employees'))
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
        return view('employees.create', compact('companies'));
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
    
        Employee::create($request->all());
     
        return redirect()->route('employees.index')
                        ->with('success','Employee created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //$company = Company::with('companyPerson')->find($employee->company_id);
        return view('employees.show',compact('employee'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = DB::table('companies')->pluck("name","id");
        $company = Company::with('employees')->find($employee->company_id);
        return view('employees.edit',compact('employee','company', 'companies'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'title' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
    
        $employee->update($request->all());
    
        return redirect()->route('employees.index')
                        ->with('success','Employee updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
    
        return redirect()->route('employees.index')
                        ->with('success','Employee deleted successfully');
    }

    
}