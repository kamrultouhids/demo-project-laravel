<?php

namespace App\Http\Controllers;

use App\Model\RabEmployeeModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\RabEmployeeRequest;
use App\Model\commonModel;
use Illuminate\Support\Facades\Auth;
use DB;

class RabEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeInfo = RabEmployeeModel::selectRabEmployeeInfo();
        return view('admin.user.rabEmployee.index',compact('employeeInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $battalionList = commonModel::selectBattalionList();
        $designationList = commonModel::selectDesignationList();
        return view('admin.user.rabEmployee.addEdit',compact('battalionList','designationList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RabEmployeeRequest $request)
    {
        $input=$request->all();
        $employeeImage = $request->file('employee_image');
        $input['created_by']=Auth::user()->id;

        if($employeeImage){
            $photo = $request->file('employee_image');
            $fileType = substr($_FILES['employee_image']['type'], 6);
            $fileName = md5(str_random(10)) . date('dmyhis') . "." . $fileType;
            $upload = $photo->move('public/uploads/employeeImage', $fileName);
            $input['employee_image'] = $fileName;
        }
        try{
            RabEmployeeModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('rabEmployee')->with('success', 'Rab Employee Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('rabEmployee')->with('error', 'Rab Employee is Found Duplicate');
        } else {
            return redirect('rabEmployee')->with('error', 'Something Error Found !, Please try again.');
        }
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
        $editRabEmployee = RabEmployeeModel::FindOrFail($id);
        $battalionList = commonModel::selectBattalionList();
        $designationList = commonModel::selectDesignationList();
        return view('admin.user.rabEmployee.addEdit',compact('battalionList','designationList','editRabEmployee'));
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
        $data = RabEmployeeModel::findOrFail($id);
        $input = $request->all();
        $employeeImage = $request->file('employee_image');
        $input['updated_by']=Auth::user()->id;
        if ($employeeImage) {
            $photo = $request->file('employee_image');
            $fileType = substr($_FILES['employee_image']['type'], 6);
            $fileName = md5(str_random(10)) . date('dmyhis') . "." . $fileType;
            $upload = $photo->move('public/uploads/employeeImage', $fileName);
            $input['employee_image'] = $fileName;
            $img_path = 'public/uploads/employeeImage/' . $data['employee_image'];

            if ($data['employee_image'] != null and file_exists($img_path)) {
                unlink($img_path);
            }
        }
        try {
            $data->update($input);
            $result = 0;
        } catch (\Exception $e) {
            $result = $e->errorInfo[1];
        }

        if ($result == 0) {
            return redirect()->back()->with('success', 'Rab Employee Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Error Found ! ');
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
        $result = RabEmployeeModel::findOrFail($id);
        if (!is_null($result->employee_image)) {
            if (file_exists('public/uploads/employeeImage/' . $result->employee_image) AND !empty($result->employee_image)) {
                unlink('public/uploads/employeeImage/' . $result->employee_image);
            }
        }
        try {
            $result->delete();
            $bug = 0;
            $error = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $error = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Slide Image Deleted Successfully');
        } elseif ($bug > 0) {
            return redirect()->back()->with('error', 'Some thing error found !');
        }
    }
    public function employeeWiseDesignationAndBattalion(Request $request){
        $emplyeeId=$request->employeeId;
        $result = DB::table('rab_employee')->where('id',$emplyeeId)->first();
        echo json_encode($result);
    }
}
