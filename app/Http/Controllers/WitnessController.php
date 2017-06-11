<?php

namespace App\Http\Controllers;

use App\Model\WitnessModel;
use App\Model\WitnessDetailsModel;
use Illuminate\Http\Request;
use App\Model\commonModel;
use DB;
use Illuminate\Support\Facades\Auth;

class WitnessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allWitness = WitnessModel::selectWitness();
        return view('admin.case.witness.index')->with('allWitness',$allWitness);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caseList = commonModel::CaseList();
        return view('admin.case.witness.form')->with('caseList',$caseList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($_POST['witnessDetails']['witness_name'])){
            return redirect()->back()->with('error', 'Witness Information should not be empty.');
        }

        $_POST['case_id'] = $_POST['case_id'];
        $_POST['date'] = dateConvertFormtoDB($_POST['date']);
        $_POST['created_by']=Auth::user()->id;

        $witnessCopy=$request->witness_attach;
        if($witnessCopy){
        $imgName=md5(str_random(10).time().'_'.$request->file('witness_attach')).'.'.$request->file('witness_attach')->getClientOriginalExtension();
        $fileName = $request->file('witness_attach')->move('public/uploads/witnessFile/',$imgName);
        $_POST['witness_attach'] = $imgName;
 
        }
        $witnessDetailsGet = $_POST['witnessDetails'];
        $witnessDetailsDataSet = [];
        for ($i = 0; $i < count($witnessDetailsGet['witness_name']); $i++) {
            $witnessDetailsDataSet['witnessDetails'][$i]['witness_cid'] = $witnessDetailsGet['witness_cid'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['witness_name'] = $witnessDetailsGet['witness_name'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['age'] = $witnessDetailsGet['age'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['gender'] = $witnessDetailsGet['gender'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['father_name'] = $witnessDetailsGet['father_name'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['mother_name'] = $witnessDetailsGet['mother_name'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['contact_no'] = $witnessDetailsGet['contact_no'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['profession'] = $witnessDetailsGet['profession'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['parmanent_address'] = $witnessDetailsGet['parmanent_address'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['present_address'] = $witnessDetailsGet['present_address'][$i];
        }

        $witnessDetailsData = $witnessDetailsDataSet;
        unset($_POST['witnessDetails']);

       $witnessData= $_POST;
      // return $witnessData;
        /*print_r($witnessDetailsData['witnessDetails']);
        exit();*/

        try {

            DB::beginTransaction();
            $result = WitnessModel::create($witnessData);

            $insert_id =$result->id;

           foreach ($witnessDetailsData['witnessDetails'] as $key => $value) {
              unset($value['witness_cid']);
               $value['fk_witness_id'] = $insert_id;
               WitnessDetailsModel::create($value);
            }

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('witness')->with('success', 'Witness Insert SuccessFully .');
        }else{
            return redirect('witness')->with('error', 'Something Error Found !, Please try again.');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editWitness = WitnessModel::FindOrFail($id);

        $editWitnessDetails = WitnessDetailsModel::selectWitnessDetailsByid($id);
        $caseList = commonModel::CaseList();
        return view('admin.case.witness.form',compact('caseList','editWitness','editWitnessDetails'));
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
        $editModeData = DB::table('witness')->where('id',$id)->first();
        if(!isset($_POST['witnessDetails']['witness_name'])){
            return redirect()->back()->with('error', 'Witness Information should not be empty.');
        }

        //$data = WitnessModel::FindOrFail($id);
        $_POST['case_id'] = $_POST['case_id'];
        $_POST['date'] = dateConvertFormtoDB($_POST['date']);
        $_POST['modified_by']=Auth::user()->id;
         $witnessCopy=$request->witness_attach;
        if($witnessCopy){
        $imgName=md5(str_random(10).time().'_'.$request->file('witness_attach')).'.'.$request->file('witness_attach')->getClientOriginalExtension();
        $fileName = $request->file('witness_attach')->move('public/uploads/witnessFile/',$imgName);
        $_POST['witness_attach'] = $imgName;
 
        }
        $witnessDetailsGet = $_POST['witnessDetails'];
        $witnessDetailsDataSet = [];
        for ($i = 0; $i < count($witnessDetailsGet['witness_name']); $i++) {
            $witnessDetailsDataSet['witnessDetails'][$i]['witness_cid'] = $witnessDetailsGet['witness_cid'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['witness_name'] = $witnessDetailsGet['witness_name'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['age'] = $witnessDetailsGet['age'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['gender'] = $witnessDetailsGet['gender'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['father_name'] = $witnessDetailsGet['father_name'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['mother_name'] = $witnessDetailsGet['mother_name'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['contact_no'] = $witnessDetailsGet['contact_no'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['profession'] = $witnessDetailsGet['profession'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['parmanent_address'] = $witnessDetailsGet['parmanent_address'][$i];
            $witnessDetailsDataSet['witnessDetails'][$i]['present_address'] = $witnessDetailsGet['present_address'][$i];
        }

        $witnessDetailsData = $witnessDetailsDataSet;


        $deleteWitnessId = explode(',',$_POST['delete_witness_cid']);

        unset($_POST['witnessDetails']);
        unset($_POST['delete_witness_cid']);
        unset($_POST['_method']);
        unset($_POST['_token']);

        $witnessData= $_POST;

        unset($witnessDetailsDataSet);

        /*print_r($witnessDetailsData['witnessDetails']);
        exit();*/

        try {

            DB::beginTransaction();


            //$result = WitnessModel::create($witnessData);
            DB::table('witness')->where('id', $id)->update($witnessData);
            //$data->update($witnessData);


            DB::table('witness_information_details')->whereIn('id',$deleteWitnessId)->delete();

            foreach ($witnessDetailsData['witnessDetails'] as $key => $value) {
                $cid = $value['witness_cid'];
                unset($value['witness_cid']);

                if($cid != ""){
                    DB::table('witness_information_details')->where('id', $cid)->update($value);
                }else{
                    $value['fk_witness_id'] = $id;
                    DB::table('witness_information_details')->insert($value);
                }
            }

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Witness  Updated Successfully.');
        }else{
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
        $witness=WitnessModel::findOrFail($id);
        $witness->delete();
        return redirect('witness')->with('success','Witness delete success !');
    }
}
