<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CoartRequest;
use App\Model\CoartInfoModel;
use App\Model\CoartInfoDetailsModel;
use App\Model\commonModel;
use DB;

class CoartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CoartInfoModel $CoartInfoModel)
    {
        $allCoartList = $CoartInfoModel->select('coart_information.id', 'coart_information.date', 'coart_information.deleted_at', 'case.reference_no')
            ->leftJoin('case', 'case.id', '=', 'coart_information.case_id')
            ->orWhereNull('coart_information.deleted_at')
            ->get();
        return view('admin.case.coartInfo.index', compact('allCoartList'));
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

        return view('admin.case.coartInfo.form', compact('caseReference'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoartRequest $request, CoartInfoModel $CoartInfoModel, CoartInfoDetailsModel $CoartInfoDetailsModel)
    {
        $details = $request->details;
        $input=$request->all();
        $case_id['case_id']= $request->case_id;
        DB::table('case')->where('id', $case_id['case_id'])->update(array('status' => 4));
        $coartCopy=$request->file('coart_attachment');

        if($coartCopy){
            $imgName=md5(str_random(10).time().'_'.$coartCopy).'.'.$coartCopy->getClientOriginalExtension();
            $fileName = $coartCopy->move('public/uploads/coartFile/',$imgName);
            $input['coart_attach'] = $imgName;
        }
        unset($request['details']);
        $input['date'] = dateConvertFormtoDB($request['date']);


        DB::beginTransaction();
        try {
            $parentData = $CoartInfoModel->create($input);
          
            $detailsDataFormat = $this->makeDetailsDataFormat($details, $parentData->id);

            foreach ($detailsDataFormat as $key => $value) {
                $CoartInfoDetailsModel->create($value);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect('coartInfo')->with('success', 'Coart Information Inserted Successfully');
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
    public function edit($id, CoartInfoModel $CoartInfoModel, CoartInfoDetailsModel $CoartInfoDetailsModel)
    {
        $caseReference= commonModel::CaseList();
        $parentData = $CoartInfoModel->select('*')->whereId($id)->first();
        $childData = $CoartInfoDetailsModel->select('*')->where('coart_info_id',$id)->get();

        return view('admin.case.coartInfo.form', compact('childData','parentData', 'caseReference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoartRequest $request, $id, CoartInfoModel $CoartInfoModel, CoartInfoDetailsModel $CoartInfoDetailsModel)
    {


        $details = $request->details;
        unset($request['details']);
           // return $request->all();
        $request['date'] = dateConvertFormtoDB($request['date']);

        $detailsDataFormat = $this->makeDetailsDataFormat($details, $id);

        $getInsertId = array_column($detailsDataFormat, 'id');
        $getPrevId = array_column($CoartInfoDetailsModel->select('id')->where('coart_info_id',$id)->get()->toArray(), 'id');
        $getDetailDeleteID = array_diff($getPrevId, $getInsertId);


        DB::beginTransaction();
        try {

                
                $coartCopy=$request->file('coart_attachment');

                if($coartCopy){
                   //return $coartCopy;
                $imgName=md5(str_random(10).time().'_'.$coartCopy).'.'.$coartCopy->getClientOriginalExtension();
                $fileName = $coartCopy->move('public/uploads/coartFile/',$imgName);
               
                $request['coart_attach'] = $imgName;
                //return $input;
                //$updateData = CoartInfoModel::findOrFail($id);
                //$updateData->update(array_merge($input));
                //return $updateData;
                }

            $CoartInfoDetailsModel->whereIn('id', $getDetailDeleteID)->delete();
             
            $parentData = $CoartInfoModel->whereId($id)->update($request->except(['_method','_token', 'coart_attachment']));
           // return "$CoartInfoModel->whereId($id)->update($request->except(['_method','_token']))";
            foreach ($detailsDataFormat as $key => $value) {

                if(isset($value['id'])){
                    $cid = $value['id'];
                    unset($value['id']);
                    $CoartInfoDetailsModel->whereId($cid)->update($value);
                }else{
                    $CoartInfoDetailsModel->create($value);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return redirect("coartInfo/$id/edit")->with('success', 'Coart Information Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CoartInfoModel $CoartInfoModel)
    {
        $CoartInfoModel->where('id', $id)->delete();
    }




    private function makeDetailsDataFormat($dataList, $id)
    {

        $detailsData = [];
        for ($i=0; $i < count($dataList['name']); $i++) {
            $detailsData[$i]['coart_info_id'] = $id;
            $detailsData[$i]['name'] = $dataList['name'][$i];
            $detailsData[$i]['description'] = $dataList['description'][$i];

            if(isset($dataList['id'][$i]))
                $detailsData[$i]['id'] = $dataList['id'][$i];

        }
        return $detailsData;
    }
}
