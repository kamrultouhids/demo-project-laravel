<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\commonModel;

use App\Model\CaseModel;

use App\Model\BattalionModel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class CaseReportController extends Controller
{
    public function index(){
        
        $employeeList       = commonModel::selectRabEmployeeList();
        $designationList    = commonModel::selectDesignationList();
        $battalionList      = commonModel::selectBattalionList();
        $lawList            = commonModel::selectlawList();
        $crimeTypeList      = commonModel::selectCrimeTypeList();
        $caseListList       = commonModel::CaseList();
        $division           = BattalionModel::selectDivision();
        $district           = BattalionModel::selectDistrict();
        $policeStation      = BattalionModel::selectPoliceStation();

        return view('admin.report.case_report',['employeeList'=>$employeeList,
            'designationList'=>$designationList,
            'battalionList'=>$battalionList,
            'lawList'=>$lawList,
            'crimeTypeList'=>$crimeTypeList,
            'caseListList'=>$caseListList,
            'division'=>$division,
            'district'=>$district,
            'policeStation'=>$policeStation,
        ]);
    }

    public function getCaseReport(Request $request){

        $results = $this->caseReportQry($request);
        echo json_encode($results);

    }
    public function casePdf(){

        //echo "<pre>";
        $filter = json_decode($_GET['data']);
        $resultData = $this->caseReportQry($filter);

        $pdf = PDF::loadView('admin.pdf.caseReportPdf',compact('resultData'));
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->stream('caseReport.pdf');

    }


    private function caseReportQry($request){

        $sql = CaseModel::query();
        $sql =$sql->select(DB::raw('`case`.*,case_convict_info.`convict_age`,case_convict_info.`convict_gender`,
                                case_law_section.`law_type`,case_victim_info.`victim_age`,`case_victim_info`.`victim_gender`,
                                rab_employee.`employee_name`,battalion.`battalion_name`,crime_type.`crime_type_name`,
                                battalion.`fk_district_id`,battalion.`fk_division_id`,battalion.`fk_police_station_id`'));
        $sql->leftJoin('case_convict_info', 'case_convict_info.case_id', '=', 'case.id');
        $sql->leftJoin('case_law_section', 'case_law_section.case_id', '=', 'case.id');
        $sql->leftJoin('case_victim_info', 'case_victim_info.case_id', '=', 'case.id');
        $sql->join('rab_employee', 'rab_employee.id', '=', 'case.litigant_name');
        $sql->join('battalion', 'battalion.id', '=', 'case.litigant_battalion');
        $sql->join('crime_type', 'crime_type.id', '=', 'case.crime_type');

        if($request->reference_no) {
            $sql->where('case.id', $request->reference_no);
        }
        if($request->litigant_name) {
            $sql->where('case.litigant_name', $request->litigant_name);
        }
        if($request->litigant_battalion) {
            $sql->where('case.litigant_battalion', $request->litigant_battalion);
        }
        if($request->status > 0) {
            $sql->where('case.status', $request->status);
        }
        if($request->convict_gender) {
            $sql->where('case_convict_info.convict_gender', $request->convict_gender);
        }
        if($request->convict_from_age) {
            $sql->where('case_convict_info.convict_age','>=', $request->convict_from_age);
        }
        if($request->convict_to_age) {
            $sql->where('case_convict_info.convict_age','<=', $request->convict_to_age);
        }
        if($request->victim_from_age) {
            $sql->where('case_victim_info.victim_age','>=', $request->victim_from_age);
        }
        if($request->victim_to_age) {
            $sql->where('case_victim_info.victim_age','<=', $request->victim_to_age);
        }
        if($request->victim_gender) {
            $sql->where('case_victim_info.victim_gender', $request->victim_gender);
        }
        if($request->crime_type) {
            $sql->where('case.crime_type', $request->crime_type);
        }
        if($request->crime_from_date) {
            $sql->where('case.crime_time','>=', dateConvertFormtoDB($request->crime_from_date));
        }
        if($request->crime_to_date) {
            $sql->where('case.crime_time','<=', dateConvertFormtoDB($request->crime_to_date));
        }
        if($request->fk_division_id) {
            $sql->where('battalion.fk_division_id', $request->fk_division_id);
        }
        if($request->fk_district_id) {
            $sql->where('battalion.fk_district_id', $request->fk_district_id);
        }
        if($request->fk_police_station_id) {
            $sql->where('battalion.fk_police_station_id', $request->fk_police_station_id);
        }

        $sql->groupBy('case.id');

        $results = $sql->get();
        return $results;
    }
    



}
