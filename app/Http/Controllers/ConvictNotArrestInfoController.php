<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConvictNotArrestInfoRequest;
use App\Model\ConvictNotArrestInfoModel;
use App\Model\ConvictNotArrestInfoDetailsModel;
use App\Model\commonModel;
use DB;

class ConvictNotArrestInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ConvictNotArrestInfoModel $ConvictNotArrestInfoModel)
    {
        $allConvictNotArrest = $ConvictNotArrestInfoModel->select('convict_not_arrest_information.id', 'convict_not_arrest_information.date', 'case.reference_no')
                                        ->leftJoin('case', 'case.id', '=', 'convict_not_arrest_information.case_id')
                                        ->get();
        return view('admin.case.convictnotarrestinfo.index', compact('allConvictNotArrest'));
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

        return view('admin.case.convictnotarrestinfo.form', compact('caseReference'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ConvictNotArrestInfoModel $ConvictNotArrestInfo, ConvictNotArrestInfoDetailsModel $ConvictNotArrestInfoDetails)
    {
        $details = $request->details;
        unset($request['details']);
        $request['date'] = dateConvertFormtoDB($request['date']);
        

        $attachment=$request->file('attachment');

        if($attachment){
            $imgName=md5(str_random(30).time().'_'.$request->file('attachment')).'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->file('attachment')->move('public/uploads/convictnotarrestinfoattach/',$imgName);
            $request['attach']=$imgName;
        }


        DB::beginTransaction();
        try {
            $parentData = $ConvictNotArrestInfo->create($request->all());
            $detailsDataFormat = $this->makeDetailsDataFormat($details, $parentData->id);

            foreach ($detailsDataFormat as $key => $value) {
                $ConvictNotArrestInfoDetails->create($value);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        

        return redirect('convictnotarrestinfo')->with('success', 'Convict Not Arrest Information Inserted Successfully');
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
    public function edit($id, ConvictNotArrestInfoModel $ConvictNotArrestInfo, ConvictNotArrestInfoDetailsModel $ConvictNotArrestInfoDetails)
    {
        $caseReference= commonModel::CaseList();
        $parentData = $ConvictNotArrestInfo->select('*')->whereId($id)->first();
        $childData = $ConvictNotArrestInfoDetails->select('*')->where('convict_not_arrest_information_id',$id)->get();

        return view('admin.case.convictnotarrestinfo.form', compact('childData','parentData', 'caseReference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ConvictNotArrestInfoModel $ConvictNotArrestInfo, ConvictNotArrestInfoDetailsModel $ConvictNotArrestInfoDetails)
    {
        $details = $request->details;
        unset($request['details']);
        $request['date'] = dateConvertFormtoDB($request['date']);

        $detailsDataFormat = $this->makeDetailsDataFormat($details, $id);

        $getInsertId = array_column($detailsDataFormat, 'id');
        $getPrevId = array_column($ConvictNotArrestInfoDetails->select('id')->where('convict_not_arrest_information_id',$id)->get()->toArray(), 'id');
        $getDetailDeleteID = array_diff($getPrevId, $getInsertId);
            

        $attachment=$request->file('attachment');
        unset($request['attachment']);
        if($attachment){
            $imgName=md5(str_random(30).time().'_'.$request->file('attachment')).'.'.$request->file('attachment')->getClientOriginalExtension();
            $request->file('attachment')->move('public/uploads/convictnotarrestinfoattach/',$imgName);
            $request['attach']=$imgName;
        }

       
        DB::beginTransaction();
        try {
            
            $ConvictNotArrestInfoDetails->whereIn('id', $getDetailDeleteID)->delete(); 

            $parentData = $ConvictNotArrestInfo->whereId($id)->update($request->except(['_method','_token', 'attachment']));
            foreach ($detailsDataFormat as $key => $value) {

                if(isset($value['id'])){
                    $cid = $value['id'];
                    unset($value['id']);
                    $ConvictNotArrestInfoDetails->whereId($cid)->update($value);
                }else{
                    $ConvictNotArrestInfoDetails->create($value);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect("convictnotarrestinfo/$id/edit")->with('success', 'Convict Not Arrest Information Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ConvictNotArrestInfoModel $ConvictNotArrestInfo)
    {
        $ConvictNotArrestInfo->where('id', $id)->delete();
    }




    private function makeDetailsDataFormat($dataList, $id)
    {
        
        $detailsData = [];
        for ($i=0; $i < count($dataList['name']); $i++) { 
            $detailsData[$i]['convict_not_arrest_information_id'] = $id;
            $detailsData[$i]['name'] = $dataList['name'][$i];
            $detailsData[$i]['description'] = $dataList['description'][$i];

            if(isset($dataList['id'][$i]))
                $detailsData[$i]['id'] = $dataList['id'][$i];

        }
        return $detailsData;
    }
}
