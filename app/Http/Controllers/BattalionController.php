<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\BattalionRequest;
use App\Model\BattalionModel;
use App\Model\commonModel;

class BattalionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBattalion = BattalionModel::selectBattalion();
        $division = BattalionModel::selectDivision();
        $district = BattalionModel::selectDistrict();
        $policeStation = BattalionModel::selectPoliceStation();
        return view('admin.setup.battalion.index',compact('division', 'district','policeStation','allBattalion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $division = BattalionModel::selectDivision();
        $district = BattalionModel::selectDistrict();
        $policeStation = BattalionModel::selectPoliceStation();
        $contactPersonList = BattalionModel::selectRabEmployeeList();
        $designationList= commonModel::selectDesignationList();
        return view('admin.setup.battalion.addEdit',compact('division', 'district','policeStation','contactPersonList','designationList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BattalionRequest $request)
    {
        $input = $request->all();
        try{
            BattalionModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('battalion')->with('success', 'Battalion Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('battalion')->with('error', 'Battalion is Found Duplicate');
        } else {
            return redirect('battalion')->with('error', 'Something Error Found !, Please try again.');
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
        $editBattalion = BattalionModel::findOrFail($id);
        $division = BattalionModel::selectDivision();
        $district = BattalionModel::selectDistrict();
        $policeStation = BattalionModel::selectPoliceStation();
        $contactPersonList = BattalionModel::selectRabEmployeeList();
        $designationList= commonModel::selectDesignationList();
        return view('admin.setup.battalion.addEdit',compact('division', 'district','policeStation','editBattalion','contactPersonList','designationList'));
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
        $data = BattalionModel::findOrFail($id);
        $input = $request->all();

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success', 'Battalion  Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
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
        $battalion = BattalionModel::find($id);
        $battalion->delete();
        return redirect()->back()->with('success', 'Battalion Deleted Successfully');
    }
}
