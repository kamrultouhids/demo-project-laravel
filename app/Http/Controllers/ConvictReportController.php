<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\commonModel;

use App\Model\CaseModel;

use App\Model\BattalionModel;

use App\Model\CaseCovictInfoModel;

use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade as PDF;

class ConvictReportController extends Controller
{
    public function index(){
        $employeeList       = commonModel::selectRabEmployeeList();
        $designationList    = commonModel::selectDesignationList();
        $battalionList      = commonModel::selectBattalionList();
        $lawList            = commonModel::selectlawList();
        $crimeTypeList      = commonModel::selectCrimeTypeList();
        $caseListList       = commonModel::CaseList();
        $crimeTypeList       = commonModel::selectCrimeTypeList();
        $lawList            = commonModel::selectlawList();
        $division           = BattalionModel::selectDivision();
        $district           = BattalionModel::selectDistrict();
        $policeStation      = BattalionModel::selectPoliceStation();

        return view('admin.report.convict_report',['employeeList'=>$employeeList,
            'designationList'=>$designationList,
            'battalionList'=>$battalionList,
            'lawList'=>$lawList,
            'crimeTypeList'=>$crimeTypeList,
            'caseListList'=>$caseListList,
            'lawList'=>$lawList,
            'crimeTypeList'=>$crimeTypeList,
            'division'=>$division,
            'district'=>$district,
            'policeStation'=>$policeStation,
        ]);
    }

    public function getConvictReport(Request $request){

        $results = $this->convictReportQuery($request);
        echo json_encode($results);

    }
    public function convictReportPdf(){
        $filter = json_decode($_GET['data']);
        $resultData = $this->convictReportQuery($filter);
        $pdf = PDF::loadView('admin.pdf.convictReportPdf',compact('resultData'));
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->stream('convictReport.pdf');
    }
    private function convictReportQuery($request){
        $sql = CaseCovictInfoModel::query();

        $sql->select(DB::raw('case.id as case_id,case_convict_info.*,case.litigant_battalion,case.reference_no,case.crime_type,
                    battalion.fk_district_id,battalion.fk_division_id,battalion.fk_police_station_id,case_law_section.law_type'));
        $sql->leftJoin('case', 'case.id', '=', 'case_convict_info.case_id');

        $sql->leftJoin('battalion', 'battalion.id', '=', 'case.litigant_battalion');
        $sql->leftJoin('case_law_section', 'case_law_section.case_id', '=', 'case_convict_info.case_id');

        if($request->case_id) {
            $sql->where('case_convict_info.case_id', $request->case_id);
        }
        if($request->convict_name) {
            $sql->where('case_convict_info.convict_name','like', '%'.$request->convict_name. '%');
        }
        if($request->convict_contact_number) {
            $sql->where('case_convict_info.convict_contact_number','like', '%'.$request->convict_contact_number.'%');
        }
        if($request->convict_father_name) {
            $sql->where('case_convict_info.convict_father_name','like', '%'.$request->convict_father_name.'%');
        }
        if($request->convict_mother_name) {
            $sql->where('case_convict_info.convict_mother_name','like', '%'.$request->convict_mother_name.'%');
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
        if($request->crime_type) {
            $sql->where('case.crime_type', $request->inputcrime_type);
        }
        if($request->law_type) {
            $sql->where('case_law_section.law_type', $request->law_type);
        }

        $sql->groupBy('case_convict_info.id');
        $sql->orderBy('case_convict_info.case_id','DESC');

        $results = $sql->get();
        return $results;
    }
}
