<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function employeeList(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::select('*')->get();
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editEmployee">Edit</a>';
                                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteEmployee">Delete</a>';
                                 return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('employee');
    }

    
    public function deleteEmployee($id)
    {  
        $delete=Employee::find($id)->delete();
        return response()->json(['success'=>'Employee deleted successfully.']);
    }

    public function createEmployee(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,'.$request->id,
            'phone' => 'required|min:10|max:10',
            'gender'=>'required'
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        Employee::updateOrCreate(['id' => $request->id],['name' => $request->name,
                'email' => $request->email,'phone' => $request->phone,'gender'=>$request->gender]);        
   
        return response()->json(['success'=>'Employee saved successfully.']);
    }

    public function editEmployee($id)
    {
        $data = Employee::find($id);
        return response()->json($data);
    }
}
