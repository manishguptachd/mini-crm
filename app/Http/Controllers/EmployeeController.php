<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee_list = Employee::with('companies')->orderBy('id','desc')->simplePaginate(10);
        $company_email = Company::select('id', 'email')->get()->toArray();
        return view('employee', compact('employee_list', 'company_email'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'f_name' => 'required|string',
                'l_name' => 'required|string',
                'companyEmail' => 'required',
                'phone' => 'required'
            ]);

            if($validator->passes())
            {
                if(!empty($request))
                {
                    $employee = Employee::create([
                        'first_name' => $request->f_name,
                        'last_name' => $request->l_name,
                        'company_id' => $request->companyEmail,
                        'phone' => $request->phone
                    ]);

                    return response()->json(array('success' => true, 'msg' => 'Employee created successfully.'));
                }
            }
            
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Employee::with('companies')->find($id);
        $data->toArray();

        return response()->json(['success' => true, 'data' => $data]);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'eFname' => 'required|string',
                'eLname' => 'required|string',
                'companyEmail1' => 'required',
                'phone1' => 'required'
            ]);

            if($validator->passes())
            {
                if(!empty($request))
                {
                    $employee = Employee::where('id', $id)->update([
                        'first_name' => $request->eFname,
                        'last_name' => $request->eLname,
                        'company_id' => $request->companyEmail1,
                        'phone' => $request->phone1
                    ]);

                    return response()->json(array('success' => true, 'msg' => 'Employee updated successfully.'));
                }
            }
            
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::find($id)->delete();
     
        return response()->json(['success' => true, 'msg' => 'Employee deleted successfully.']);
    }
}
