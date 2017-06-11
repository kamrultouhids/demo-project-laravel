<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\DistrictRequest;
use App\Model\DistrictModel;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = array(
            'districtInfo' => DistrictModel::selectDistrict()
        );
        return view('admin.setup.district.index')->with('result',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result = array(
            'divisionInfo' => DistrictModel::selectDivision()
        );
       return view('admin.setup.district.addEdit')->with('result',$result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictRequest $request)
    {
        $input = $request->all();

        try{
            DistrictModel::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('district')->with('success', 'District Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('district')->with('error', 'District is Found Duplicate');
        } else {
            return redirect('district')->with('error', 'Something Error Found !, Please try again.');
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
        $result = array(
            'editDistrict' => DistrictModel::findOrFail($id),
            'divisionInfo' => DistrictModel::selectDivision(),
        );
        return view('admin.setup.district.addEdit')->with('result',$result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request, $id)
    {
        $data = DistrictModel::findOrFail($id);
        $input = $request->all();

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success', 'District Updated Successfully');
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
        $districtDelete = DistrictModel::find($id);
        $districtDelete->delete();
        return redirect()->back()->with('success', 'District Deleted Successfully');
    }
    public function getdistrict(Request $request)
    {

        //$anothermsg = "This is a simple message.";
        $divisionId=$request->divisionId;
        echo $divisionId;
        exit;
        $division = DB::table("districts")->select('id', 'name')->where("division_id",$divisionId)->get();

        return response()->json(array('msg'=> $division));
        //return response()->json(array('msg'=> $division,'anothermsg'=> $anothermsg));

    }
}
