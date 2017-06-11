<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\DesignationRequest;
use App\Model\DesignationModel;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allDesignation = DesignationModel::selectDesignation();
        return view('admin.user.designation.index')->with('allDesignation',$allDesignation);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.designation.addEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignationRequest $request)
    {
        //$input['created_by']=Auth::user()->id;
        $input = $request->all();
        try{
            DesignationModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug == 0){
            return redirect('designation')->with('success', 'Designation Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('designation')->with('error', 'Designation is Found Duplicate');
        } else {
            return redirect('designation')->with('error', 'Something Error Found !, Please try again.');
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
        $editDesignation = DesignationModel::FindOrFail($id);
        return view('admin.user.designation.addEdit')->with('editDesignation',$editDesignation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DesignationRequest $request, $id)
    {
        $data = DesignationModel::findOrFail($id);
        $input = $request->all();

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success', 'Designation Updated Successfully');
        }else {
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
        $designationDelete = DesignationModel::find($id);
        $designationDelete->delete();
        return redirect()->back()->with('success', 'Designation Deleted Successfully');
    }
}
