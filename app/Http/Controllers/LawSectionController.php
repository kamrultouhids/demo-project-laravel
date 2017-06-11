<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LawSectionRequest;
use App\Model\LawSectionModel;

class LawSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allLawSection = LawSectionModel::selectLawSection();
        return view('admin.setup.lawSection.index')->with('allLawSection',$allLawSection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setup.lawSection.addEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LawSectionRequest $request)
    {
        $input=$request->all();
        try{
            LawSectionModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('lawSection')->with('success', 'Law Section Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('lawSection')->with('error', 'Law Section is Found Duplicate');
        } else {
            return redirect('lawSection')->with('error', 'Something Error Found !, Please try again.');
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
        $editLawSection = LawSectionModel::FindOrFail($id);
        return view('admin.setup.lawSection.addEdit')->with('editLawSection',$editLawSection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LawSectionRequest $request, $id)
    {
        $data = LawSectionModel::findOrFail($id);
        $input = $request->all();
        try {
            $data->update($input);
            $result = 0;
        } catch (\Exception $e) {
            $result = $e->errorInfo[1];
        }
        if ($result == 0) {
            return redirect()->back()->with('success', 'Law Section Updated Successfully');
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
        $lawSectionDelete = LawSectionModel::find($id);
        $lawSectionDelete->delete();
        return redirect()->back()->with('success', 'Law Section Deleted Successfully');
    }
}
