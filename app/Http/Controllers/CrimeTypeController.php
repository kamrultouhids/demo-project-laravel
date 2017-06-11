<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CrimeTypeRequest;
use App\Model\CrimeTypeModel;

class CrimeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCrimeType = CrimeTypeModel::selectCrimeType();
        return view('admin.setup.crimeType.index')->with('allCrimeType',$allCrimeType);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setup.crimeType.addEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrimeTypeRequest $request)
    {
        $input=$request->all();

        try{
            CrimeTypeModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('crimeType')->with('success', 'Crime Type Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('crimeType')->with('error', 'Crime Type is Found Duplicate');
        } else {
            return redirect('crimeType')->with('error', 'Something Error Found !, Please try again.');
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
        $editCrimeType = CrimeTypeModel::FindOrFail($id);
        return view('admin.setup.crimeType.addEdit')->with('editCrimeType',$editCrimeType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CrimeTypeRequest $request, $id)
    {
        $data = CrimeTypeModel::findOrFail($id);
        $input = $request->all();
        try {
            $data->update($input);
            $result = 0;
        } catch (\Exception $e) {
            $result = $e->errorInfo[1];
        }
        if ($result == 0) {
            return redirect()->back()->with('success', 'Crime Type Updated Successfully');
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
        $crimeTypeDelete = CrimeTypeModel::find($id);
        $crimeTypeDelete->delete();
        return redirect()->back()->with('success', 'Crime Type Deleted Successfully');
    }
}
