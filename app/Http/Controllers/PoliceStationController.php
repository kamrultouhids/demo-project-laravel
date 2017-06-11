<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\PoliceStationRequest;
use App\Model\PoliceStationModel;


class PoliceStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPoliceStation = PoliceStationModel::selectPoliceStation();
        return view('admin.setup.policeStation.index',compact('allPoliceStation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $division = PoliceStationModel::selectDivision();
        $district = PoliceStationModel::selectDistrict();
        return view('admin.setup.policeStation.addEdit',compact('division', 'district'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PoliceStationRequest $request)
    {
        $input = $request->all();

        try{
            PoliceStationModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('policeStation')->with('success', 'Police Station Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('policeStation')->with('error', 'Police Station is Found Duplicate');
        } else {
            return redirect('policeStation')->with('error', 'Something Error Found !, Please try again.');
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
        $editPoliceStation = PoliceStationModel::findOrFail($id);
        $division = PoliceStationModel::selectDivision();
        $district = PoliceStationModel::selectDistrict();
        return view('admin.setup.policeStation.addEdit',compact('division', 'district','editPoliceStation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PoliceStationRequest $request, $id)
    {
        $data = PoliceStationModel::findOrFail($id);
        $input = $request->all();

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success', 'Police Station Updated Successfully');
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
        $policeStationDelete = PoliceStationModel::find($id);
        $policeStationDelete->delete();
        return redirect()->back()->with('success', 'Police Station Deleted Successfully');
    }

    public function getDistrict(){
        echo "ok";exit;
    }

}
