<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ConvictArrestInfo;
use App\Http\Requests\ConvictArrestInfo as ConvictArrestInfoRequest;
use App\Model\ConvictArrestInfo as ConvictArrestInfoModel;
use App\Model\ConvictArrestInfoDetails as ConvictArrestInfoDetailsModel;
use App\Model\commonModel;
use DB;

class ConvictArrestInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ConvictArrestInfo $convictArrestInfo)
    {
        $allConvictArrest = $convictArrestInfo->select('convict_arrest_information.id', 'convict_arrest_information.date', 'case.reference_no')
                                        ->leftJoin('case', 'case.id', '=', 'convict_arrest_information.case_id')
                                        ->get();
        return view('admin.case.convictarrestinfo.index', compact('allConvictArrest'));
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

        return view('admin.case.convictarrestinfo.form', compact('caseReference'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConvictArrestInfoRequest $request, ConvictArrestInfoModel $ConvictArrestInfo, ConvictArrestInfoDetailsModel $ConvictArrestInfoDetails)
    {


        $details = $request->details;
        unset($request['details']);
        $request['date'] = dateConvertFormtoDB($request['date']);


        $attachment=$request->file('attachment');

        if($attachment){
            $imgName=md5(str_random(30).time().'_'.$request->file('attachment')).'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->file('attachment')->move('public/uploads/convictarrestinfoattach/',$imgName);
            $request['attach']=$imgName;
        }

        DB::beginTransaction();
        try {
            $parentData = $ConvictArrestInfo->create($request->all());
            $detailsDataFormat = $this->makeDetailsDataFormat($details, $parentData->id);

            foreach ($detailsDataFormat as $key => $value) {
                $ConvictArrestInfoDetails->create($value);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        

        return redirect('convictarrestinfo')->with('success', 'Convict Arrest Information Inserted Successfully');
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
    public function edit($id, ConvictArrestInfoModel $ConvictArrestInfo, ConvictArrestInfoDetailsModel $ConvictArrestInfoDetails)
    {
        //
        $caseReference= commonModel::CaseList();
        $parentData = $ConvictArrestInfo->select('*')->whereId($id)->first();
        $childData = $ConvictArrestInfoDetails->select('*')->where('convict_arrest_information_id',$id)->get();

        return view('admin.case.convictarrestinfo.form', compact('childData','parentData', 'caseReference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ConvictArrestInfoModel $ConvictArrestInfo, ConvictArrestInfoDetailsModel $ConvictArrestInfoDetails)
    {
        $details = $request->details;
        unset($request['details']);
        $request['date'] = dateConvertFormtoDB($request['date']);


        $attachment=$request->file('attachment');
        unset($request['attachment']);
        if($attachment){
            $imgName=md5(str_random(30).time().'_'.$request->file('attachment')).'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->file('attachment')->move('public/uploads/convictarrestinfoattach/',$imgName);
            $request['attach']=$imgName;
        }

        
        
        $detailsDataFormat = $this->makeDetailsDataFormat($details, $id);

        $getInsertId = array_column($detailsDataFormat, 'id');
        $getPrevId = array_column($ConvictArrestInfoDetails->select('id')->where('convict_arrest_information_id',$id)->get()->toArray(), 'id');
        $getDetailDeleteID = array_diff($getPrevId, $getInsertId);
            

        DB::beginTransaction();
        try {
            
            $ConvictArrestInfoDetails->whereIn('id', $getDetailDeleteID)->delete(); 

            $parentData = $ConvictArrestInfo->whereId($id)->update($request->except(['_method','_token', 'attachment']));
            foreach ($detailsDataFormat as $key => $value) {

                if(isset($value['id'])){
                    $cid = $value['id'];
                    unset($value['id']);
                    $ConvictArrestInfoDetails->whereId($cid)->update($value);
                }else{
                    $ConvictArrestInfoDetails->create($value);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect("convictarrestinfo/$id/edit")->with('success', 'Convict Arrest Information Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ConvictArrestInfoModel $ConvictArrestInfo)
    {
        $ConvictArrestInfo->where('id', $id)->delete(); 
    }


    private function makeDetailsDataFormat($dataList, $id)
    {
        
        $detailsData = [];
        for ($i=0; $i < count($dataList['name']); $i++) { 
            $detailsData[$i]['convict_arrest_information_id'] = $id;
            $detailsData[$i]['name'] = $dataList['name'][$i];
            $detailsData[$i]['place'] = $dataList['place'][$i];
            $detailsData[$i]['legal_goods_seized'] = $dataList['legal_goods_seized'][$i];
            $detailsData[$i]['illegal_goods_seized'] = $dataList['illegal_goods_seized'][$i];

            if(isset($dataList['id'][$i]))
                $detailsData[$i]['id'] = $dataList['id'][$i];

        }
        return $detailsData;
    }


}
