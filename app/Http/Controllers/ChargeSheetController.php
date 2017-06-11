<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChargeSheetRequest;
use App\Model\ChargeSheetModel;
use App\Model\ChargeSheetDetailsModel;
use App\Model\commonModel;
use DB;

class ChargeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChargeSheetModel $ChargeSheet)
    {
        $allChargeSheet = $ChargeSheet->select('chargesheet_information.id', 'chargesheet_information.date', 'case.reference_no')
                                        ->leftJoin('case', 'case.id', '=', 'chargesheet_information.case_id')
                                        ->get();
        return view('admin.case.chargesheet.index', compact('allChargeSheet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $caseReference= commonModel::CaseList();

        return view('admin.case.chargesheet.form', compact('caseReference'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ChargeSheetModel $ChargeSheet, ChargeSheetDetailsModel $ChargeSheetDetails)
    {
        $input=$request->all();
        $case_id['case_id']= $request->case_id;
        DB::table('case')->where('id', $case_id['case_id'])->update(array('status' => 3));
        $details = $request->details;
        unset($input['details']);
        $input['date'] = dateConvertFormtoDB($request['date']);
        
        //return $chargesheetCopy;
        $chargesheetCopy=$request->file('chargesheet_attach');
        if($chargesheetCopy){
        $imgName=md5(str_random(10).time().'_'.$request->file('chargesheet_attach')).'.'.$request->file('chargesheet_attach')->getClientOriginalExtension();
        $fileName = $request->file('chargesheet_attach')->move('public/uploads/chargesheetFile/',$imgName);
        $input['chargesheet_attach'] = $imgName;
        //return $input;
        }



        DB::beginTransaction();
        try {
            $parentData = $ChargeSheet->create($input);
            $detailsDataFormat = $this->makeDetailsDataFormat($details, $parentData->id);

            foreach ($detailsDataFormat as $key => $value) {
                $ChargeSheetDetails->create($value);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        

        return redirect('chargesheet')->with('success', 'Charge Sheet Inserted Successfully');
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
    public function edit($id, ChargeSheetModel $ChargeSheet, ChargeSheetDetailsModel $ChargeSheetDetails)
    {
        //
        $caseReference= commonModel::CaseList();
        $parentData = $ChargeSheet->select('*')->whereId($id)->first();
        $childData = $ChargeSheetDetails->select('*')->where('chargesheet_information_id',$id)->get();

        return view('admin.case.chargesheet.form', compact('childData','parentData', 'caseReference'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ChargeSheetModel $ChargeSheet, ChargeSheetDetailsModel $ChargeSheetDetails)
    {
        $details = $request->details;
        unset($request['details']);
        $request['date'] = dateConvertFormtoDB($request['date']);

        $detailsDataFormat = $this->makeDetailsDataFormat($details, $id);

        $getInsertId = array_column($detailsDataFormat, 'id');
        $getPrevId = array_column($ChargeSheetDetails->select('id')->where('chargesheet_information_id',$id)->get()->toArray(), 'id');
        $getDetailDeleteID = array_diff($getPrevId, $getInsertId);

        // echo "<pre>";
        // print_r($getDetailDeleteID);
        // exit();

        DB::beginTransaction();
        try {
            
            $ChargeSheetDetails->whereIn('id', $getDetailDeleteID)->delete(); 

            $parentData = $ChargeSheet->whereId($id)->update($request->except(['_method','_token']));
            $chargesheetCopy=$request->file('chargesheet_attach');
            if($chargesheetCopy){
            $imgName=md5(str_random(10).time().'_'.$request->file('chargesheet_attach')).'.'.$request->file('chargesheet_attach')->getClientOriginalExtension();
            $fileName = $request->file('chargesheet_attach')->move('public/uploads/chargesheetFile/',$imgName);
            $input['chargesheet_attach'] = $imgName;
        //return $input;
            $updateData = ChargeSheetModel::findOrFail($id);
            $updateData->update(array_merge($input));
            }
            foreach ($detailsDataFormat as $key => $value) {

                if(isset($value['id'])){
                    $cid = $value['id'];
                    unset($value['id']);
                    $ChargeSheetDetails->whereId($cid)->update($value);
                }else{
                    $ChargeSheetDetails->create($value);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect("chargesheet/$id/edit")->with('success', 'Charge Sheet Information Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ChargeSheetModel $ChargeSheet)
    {
        $ChargeSheet->where('id', $id)->delete();
    }





    private function makeDetailsDataFormat($dataList, $id)
    {
        
        $detailsData = [];
        for ($i=0; $i < count($dataList['convict_name']); $i++) { 
            $detailsData[$i]['chargesheet_information_id'] = $id;
            $detailsData[$i]['convict_name'] = $dataList['convict_name'][$i];
            $detailsData[$i]['convict_age'] = $dataList['convict_age'][$i];
            $detailsData[$i]['convict_gender'] = $dataList['convict_gender'][$i];
            $detailsData[$i]['convict_father_name'] = $dataList['convict_father_name'][$i];
            $detailsData[$i]['convict_mother_name'] = $dataList['convict_mother_name'][$i];
            $detailsData[$i]['convict_contact_number'] = $dataList['convict_contact_number'][$i];
            $detailsData[$i]['convict_permanent_address'] = $dataList['convict_permanent_address'][$i];
            $detailsData[$i]['convict_present_address'] = $dataList['convict_present_address'][$i];
            $detailsData[$i]['convict_pastcase'] = $dataList['convict_pastcase'][$i];
            $detailsData[$i]['convict_details'] = $dataList['convict_details'][$i];

            if(isset($dataList['id'][$i]))
                $detailsData[$i]['id'] = $dataList['id'][$i];

        }
        return $detailsData;
    }
}
