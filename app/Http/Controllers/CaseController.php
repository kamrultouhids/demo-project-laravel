<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Model\commonModel;

use App\Model\CaseModel;

use App\Http\Requests\caseRequest;

use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('case')->orWhereNull('deleted_at')->get();
        return view('admin.case.case.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeList= commonModel::selectRabEmployeeList();
        $designationList= commonModel::selectDesignationList();
        $battalionList= commonModel::selectBattalionList();
        $lawList= commonModel::selectlawList();
        $crimeTypeList= commonModel::selectCrimeTypeList();
        return view('admin.case.case.form',['employeeList'=>$employeeList,
                                            'designationList'=>$designationList,
                                            'battalionList'=>$battalionList,
                                            'lawList'=>$lawList,
                                            'crimeTypeList'=>$crimeTypeList,
                                            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(caseRequest $request)
    {
        date_default_timezone_set("Asia/Dhaka");
        $frrCopy=$request->file('fir_attach');
        if($frrCopy){
            $imgName=md5(str_random(30).time().'_'.$request->file('fir_attach')).'.'.$request->file('fir_attach')->getClientOriginalExtension();
            $request->file('fir_attach')->move('public/uploads/fircopy/',$imgName);
            $_POST['fir_attach']=$imgName;
        }

        if(!isset($_POST['convictDetails']['convict_name'])){
            return redirect()->back()->with('error', 'Convict Information should not be empty.');
        }

        if(!isset($_POST['victimsDetails']['victim_name'])){
            return redirect()->back()->with('error', 'victim Information should not be empty.');
        }

        if(!isset($_POST['lawDetails']['law_type'])){
            return redirect()->back()->with('error', 'Law  Information should not be empty.');
        }

        $convictDetailsDataGet = $_POST['convictDetails'];
        $victimsDetailsDataGet = $_POST['victimsDetails'];
        $lawDetailsDataGet = $_POST['lawDetails'];



        $convictDetailsDataSet = [];
        for ($i = 0; $i < count($convictDetailsDataGet['convict_name']); $i++) {
            $convictDetailsDataSet['convictDetails'][$i]['convict_cid'] = $convictDetailsDataGet['convict_cid'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_name'] = $convictDetailsDataGet['convict_name'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_age'] = $convictDetailsDataGet['convict_age'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_gender'] = $convictDetailsDataGet['convict_gender'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_father_name'] = $convictDetailsDataGet['convict_father_name'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_mother_name'] = $convictDetailsDataGet['convict_mother_name'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_contact_number'] = $convictDetailsDataGet['convict_contact_number'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_permanent_address'] = $convictDetailsDataGet['convict_permanent_address'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_present_address'] = $convictDetailsDataGet['convict_present_address'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_pastcase'] = $convictDetailsDataGet['convict_pastcase'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_details'] = $convictDetailsDataGet['convict_details'][$i];
        }

        $victimsDetailsDataSet = [];
        for ($i = 0; $i < count($victimsDetailsDataGet['victim_name']); $i++) {
            $victimsDetailsDataSet['victimsDetails'][$i]['victims_cid'] = $victimsDetailsDataGet['victims_cid'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_name'] = $victimsDetailsDataGet['victim_name'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_age'] = $victimsDetailsDataGet['victim_age'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_gender'] = $victimsDetailsDataGet['victim_gender'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_father_name'] = $victimsDetailsDataGet['victim_father_name'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_mother_name'] = $victimsDetailsDataGet['victim_mother_name'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_contact_number'] = $victimsDetailsDataGet['victim_contact_number'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_permanent_address'] = $victimsDetailsDataGet['victim_permanent_address'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_present_address'] = $victimsDetailsDataGet['victim_present_address'][$i];
        }

        $law_typeDataSet = [];
        for ($i = 0; $i < count($lawDetailsDataGet['law_type']); $i++) {
            $law_typeDataSet['lawDetails'][$i]['law_cid'] = $lawDetailsDataGet['law_cid'][$i];
            $law_typeDataSet['lawDetails'][$i]['law_type'] = $lawDetailsDataGet['law_type'][$i];
        }

        $convictDetailsData = $convictDetailsDataSet;
        $victimsDetailssData = $victimsDetailsDataSet;
        $law_typeDataData = $law_typeDataSet;

        unset($_POST['convictDetails']);
        unset($_POST['victimsDetails']);
        unset($_POST['lawDetails']);
        unset($_POST['_token']);

        $_POST['crime_time'] = dateConvertFormtoDB($_POST['crime_time']);
        $_POST['created_at'] = date('Y-m-d H:i:s');
        $_POST['created_by'] =Auth::user()->id;

        $caseData= $_POST;

        unset($convictDetailsDataSet);
        unset($victimsDetailsDataSet);
        unset($law_typeDataSet);


        try {

            DB::beginTransaction();

            $result = DB::table('case')->insertGetId($caseData);
            $insert_id =$result;


            $createPOI = ['reference_no'=>'CASE'.-date('Ymd').$insert_id];
            DB::table('case')->where('id', $insert_id)->update($createPOI);

            foreach ($convictDetailsData['convictDetails'] as $key => $value) {

                unset($value['convict_cid']);
                $value['case_id'] = $insert_id;
                DB::table('case_convict_info')->insert($value);

            }

            foreach ($victimsDetailssData['victimsDetails'] as $key => $vitimsValue) {

                unset($vitimsValue['victims_cid']);
                $vitimsValue['case_id'] = $insert_id;
                DB::table('case_victim_info')->insert($vitimsValue);

            }

            foreach ($law_typeDataData['lawDetails'] as $key => $lawValue) {

                unset($lawValue['law_cid']);
                $lawValue['case_id'] = $insert_id;
                DB::table('case_law_section')->insert($lawValue);

            }

            DB::commit();

            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('case')->with('success', 'Case Insert SuccessFully .');
        }else{
            return redirect('case')->with('error', 'Something Error Found !, Please try again.');
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
        $editModeData = DB::table('case')->select('case.*','rab_employee.employee_name','designation.designation_name','battalion.battalion_name','crime_type.crime_type_name')
            ->join('rab_employee','rab_employee.id','=','case.litigant_name')
            ->join('designation','designation.id','=','case.litigant_designation')
            ->join('battalion','battalion.id','=','case.litigant_battalion')
            ->join('crime_type','crime_type.id','=','case.crime_type')
            ->orWhereNull('case.deleted_at')->where('case.id',$id)->first();

        $ConvictEditModeData = DB::table('case_convict_info')->where('case_id',$id)->get();
        $victimsEditModeData = DB::table('case_victim_info')->where('case_id',$id)->get();
        $lawEditModeData = DB::table('case_law_section')->select('case_law_section.*','law_section.section_name')->join('law_section','law_section.id','=','case_law_section.law_type')->where('case_law_section.case_id',$id)->get();

        $pdf = PDF::loadView('admin.case.case.formPdf',[
            'editModeData' => $editModeData,
            'ConvictEditModeData'=>$ConvictEditModeData,
            'victimsEditModeData'=>$victimsEditModeData,
            'lawEditModeData'=>$lawEditModeData
        ]);
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->stream();

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $employeeList= commonModel::selectRabEmployeeList();
        $designationList= commonModel::selectDesignationList();
        $battalionList= commonModel::selectBattalionList();
        $lawList= commonModel::selectlawList();
        $crimeTypeList= commonModel::selectCrimeTypeList();

        $editModeData = DB::table('case')->orWhereNull('deleted_at')->where('id',$id)->first();
        if (empty($editModeData)) {
            return redirect('admin_home');
        }

        $ConvictEditModeData = DB::table('case_convict_info')->where('case_id',$id)->get();
        $victimsEditModeData = DB::table('case_victim_info')->where('case_id',$id)->get();
        $lawEditModeData = DB::table('case_law_section')->where('case_id',$id)->get();


        return view('admin.case.case.form',[
                                            'editModeData' => $editModeData,
                                            'ConvictEditModeData'=>$ConvictEditModeData,
                                            'victimsEditModeData'=>$victimsEditModeData,
                                            'lawEditModeData'=>$lawEditModeData,
                                            'employeeList'=>$employeeList,
                                            'designationList'=>$designationList,
                                            'battalionList'=>$battalionList,
                                            'lawList'=>$lawList,
                                            'crimeTypeList'=>$crimeTypeList,
                                        ]);
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
        $editModeData = DB::table('case')->where('id',$id)->first();

        $frrCopy=$request->file('fir_attach');
        if($frrCopy){
            $imgName=md5(str_random(30).time().'_'.$request->file('fir_attach')).'.'.$request->file('fir_attach')->getClientOriginalExtension();
            $request->file('fir_attach')->move('public/uploads/fircopy/',$imgName);
            if(file_exists('public/uploads/fircopy/'.$editModeData->fir_attach) AND !empty($editModeData->fir_attach)){
                unlink('public/uploads/fircopy/'.$editModeData->fir_attach);
            }
            $_POST['fir_attach']=$imgName;
        }

        if(!isset($_POST['convictDetails']['convict_name'])){
            return redirect()->back()->with('error', 'Convict Information should not be empty.');
        }

        if(!isset($_POST['victimsDetails']['victim_name'])){
            return redirect()->back()->with('error', 'victim Information should not be empty.');
        }

        if(!isset($_POST['lawDetails']['law_type'])){
            return redirect()->back()->with('error', 'Law  Information should not be empty.');
        }

        $convictDetailsDataGet = $_POST['convictDetails'];
        $victimsDetailsDataGet = $_POST['victimsDetails'];
        $lawDetailsDataGet = $_POST['lawDetails'];


        $convictDetailsDataSet = [];
        for ($i = 0; $i < count($convictDetailsDataGet['convict_name']); $i++) {
            $convictDetailsDataSet['convictDetails'][$i]['convict_cid'] = $convictDetailsDataGet['convict_cid'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_name'] = $convictDetailsDataGet['convict_name'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_age'] = $convictDetailsDataGet['convict_age'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_gender'] = $convictDetailsDataGet['convict_gender'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_father_name'] = $convictDetailsDataGet['convict_father_name'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_mother_name'] = $convictDetailsDataGet['convict_mother_name'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_contact_number'] = $convictDetailsDataGet['convict_contact_number'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_permanent_address'] = $convictDetailsDataGet['convict_permanent_address'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_present_address'] = $convictDetailsDataGet['convict_present_address'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_pastcase'] = $convictDetailsDataGet['convict_pastcase'][$i];
            $convictDetailsDataSet['convictDetails'][$i]['convict_details'] = $convictDetailsDataGet['convict_details'][$i];
        }

        $victimsDetailsDataSet = [];
        for ($i = 0; $i < count($victimsDetailsDataGet['victim_name']); $i++) {
            $victimsDetailsDataSet['victimsDetails'][$i]['victims_cid'] = $victimsDetailsDataGet['victims_cid'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_name'] = $victimsDetailsDataGet['victim_name'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_age'] = $victimsDetailsDataGet['victim_age'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_gender'] = $victimsDetailsDataGet['victim_gender'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_father_name'] = $victimsDetailsDataGet['victim_father_name'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_mother_name'] = $victimsDetailsDataGet['victim_mother_name'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_contact_number'] = $victimsDetailsDataGet['victim_contact_number'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_permanent_address'] = $victimsDetailsDataGet['victim_permanent_address'][$i];
            $victimsDetailsDataSet['victimsDetails'][$i]['victim_present_address'] = $victimsDetailsDataGet['victim_present_address'][$i];
        }

        $law_typeDataSet = [];
        for ($i = 0; $i < count($lawDetailsDataGet['law_type']); $i++) {
            $law_typeDataSet['lawDetails'][$i]['law_cid'] = $lawDetailsDataGet['law_cid'][$i];
            $law_typeDataSet['lawDetails'][$i]['law_type'] = $lawDetailsDataGet['law_type'][$i];
        }

        $convictDetailsData = $convictDetailsDataSet;
        $victimsDetailssData = $victimsDetailsDataSet;
        $law_typeDataData = $law_typeDataSet;
        

        $delete_convict_ids = explode(',',$_POST['delete_convict_cid']);
        $delete_victims_ids = explode(',',$_POST['delete_victims_cid']);
        $delete_law_ids = explode(',',$_POST['delete_law_cid']);


        unset($_POST['convictDetails']);
        unset($_POST['victimsDetails']);
        unset($_POST['lawDetails']);
        unset($_POST['_token']);

        unset($_POST['delete_convict_cid']);
        unset($_POST['delete_victims_cid']);
        unset($_POST['delete_law_cid']);
        unset($_POST['_method']);

        $_POST['crime_time'] = dateConvertFormtoDB($_POST['crime_time']);
        $_POST['updated_at'] = date('Y-m-d H:i:s');
        $_POST['modified_by'] =Auth::user()->id;

        $caseData= $_POST;

        unset($convictDetailsDataSet);
        unset($victimsDetailsDataSet);
        unset($law_typeDataSet);

        try{
            DB::beginTransaction();

            // Update Parent Data
            DB::table('case')->where('id', $id)->update($caseData);

            // Delete Child ID
            DB::table('case_convict_info')->whereIn('id',$delete_convict_ids)->delete();
            DB::table('case_victim_info')->whereIn('id',$delete_victims_ids)->delete();
            DB::table('case_law_section')->whereIn('id',$delete_law_ids)->delete();

            foreach ($convictDetailsData['convictDetails'] as $key => $value) {
                $cid = $value['convict_cid'];
                unset($value['convict_cid']);

                if($cid != ""){
                    DB::table('case_convict_info')->where('id', $cid)->update($value);
                }else{
                    $value['case_id'] = $id;
                    DB::table('case_convict_info')->insert($value);
                }
            }

            foreach ($victimsDetailssData['victimsDetails'] as $key => $value) {
                $cid = $value['victims_cid'];
                unset($value['victims_cid']);

                if($cid != ""){
                    DB::table('case_victim_info')->where('id', $cid)->update($value);
                }else{
                    $value['case_id'] = $id;
                    DB::table('case_victim_info')->insert($value);
                }
            }

            foreach ($law_typeDataData['lawDetails'] as $key => $value) {
                $cid = $value['law_cid'];
                unset($value['law_cid']);

                if($cid != ""){
                    DB::table('case_law_section')->where('id', $cid)->update($value);
                }else{
                    $value['case_id'] = $id;
                    DB::table('case_law_section')->insert($value);
                }
            }

            DB::commit();

            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success', 'Case Update Successfully');
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
        $case=CaseModel::findOrFail($id);
        $case->delete();
        return redirect()->back()->with('success','Case delete success !');
    }




    public function CaseConvictList($cid)
    {
        $ConvictEditModeData = DB::table('case_convict_info')->select('*')->where('case_id',$cid)->get()->toArray();
        return $ConvictEditModeData;
    }

}
