<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class HomeController extends Controller
{
    public function index()
    {
   
 
    }

    public function admin_home()
    {
        $year=date("Y");

        /////////////////////Case Chart Start///////////////////////////////

         $quryYear = DB::table("case")
                    ->groupBy(DB::raw("Year(created_at)"))
                    ->orderBy(DB::raw("YEAR(created_at)"),'Desc')
                    ->select(DB::raw("Year(created_at) as year"))
                    ->get()
                    ->toarray();

        $qryCaseId = DB::table("case")
            ->select(DB::raw("MONTHNAME(created_at) as monthname"),DB::raw("(COUNT(*)) as total_case"), DB::raw("Year(created_at) as year"),DB::raw("MONTH(created_at) as month"))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->whereYear('created_at', '=', $year)
            ->get();




        foreach ($qryCaseId as $v){

            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)"$value[2]-$value[3]";
            unset($value[3]);
            $dataCase[] = $value ;
        }

//return $dataCase;




        ////////////////////////////Coart Chart Start/////////////////////////////////
        $qryCoart = DB::table("case")
            ->join('coart_information', 'case.id', '=', 'coart_information.case_id')
            ->select(DB::raw("MONTHNAME(coart_information.created_at) as monthname"),DB::raw("(COUNT(*)) as total_coart"), DB::raw('GROUP_CONCAT(case.reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(coart_information.created_at)"))
            ->orderBy(DB::raw("MONTH(coart_information.created_at)"))
            ->whereYear('coart_information.created_at', '=', $year)
            ->get();




        foreach ($qryCoart as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataCoart[] = $value ;
        }

        $quryYearCoart = DB::table("coart_information")
            ->groupBy(DB::raw("Year(created_at)"))
            ->orderBy(DB::raw("YEAR(created_at)"),'Desc')
            ->select(DB::raw("Year(created_at) as year"))
            ->get()
            ->toarray();
        







        //////////////////////Start Investigation//////////////////////////////////////////////

        $qryInvestigation = DB::table("case")
            ->join('investigation_details', 'case.id', '=', 'investigation_details.case_number')
            ->select(DB::raw("MONTHNAME(investigation_details.created_at) as monthname"),DB::raw("(COUNT(*)) as total_case"), DB::raw('GROUP_CONCAT(case.reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(investigation_details.created_at)"))
            ->orderBy(DB::raw("MONTH(investigation_details.created_at)"))
            ->whereYear('investigation_details.created_at', '=', $year)
            ->get();




        foreach ($qryInvestigation as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataInvestigation[] = $value ;
        }

        $quryYearInvestigation = DB::table("investigation_details")
            ->groupBy(DB::raw("Year(created_at)"))
            ->orderBy(DB::raw("YEAR(created_at)"),'Desc')
            ->select(DB::raw("Year(created_at) as year"))
            ->get()
            ->toarray();



        ////////////////////////////////Start Chargesheet//////////////////////////////////////////////////////



        $qryChargesheet = DB::table("case")
            ->join('chargesheet_information', 'case.id', '=', 'chargesheet_information.case_id')
            ->select(DB::raw("MONTHNAME(chargesheet_information.created_at) as monthname"),DB::raw("(COUNT(*)) as total_case"), DB::raw('GROUP_CONCAT(case.reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(chargesheet_information.created_at)"))
            ->orderBy(DB::raw("MONTH(chargesheet_information.created_at)"))
            ->whereYear('chargesheet_information.created_at', '=', $year)
            ->get();




        foreach ($qryChargesheet as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataChargesheet[] = $value ;
        }
        $quryYearChargesheet = DB::table("chargesheet_information")
            ->groupBy(DB::raw("Year(created_at)"))
            ->orderBy(DB::raw("YEAR(created_at)"),'Desc')
            ->select(DB::raw("Year(created_at) as year"))
            ->get()
            ->toarray();

       // return $arrayChargesheetData;



        $quryConvict= DB::select("SELECT monthname(`case`.created_at)as month,
    (SELECT  count(case_convict_info.convict_gender) from case_convict_info
        INNER JOIN `case` ON `case`.id=case_convict_info.case_id WHERE monthname(`case`.created_at)=month and case_convict_info.convict_gender='male')  as male,
(SELECT  count(case_convict_info.convict_gender) from case_convict_info
        INNER JOIN `case` ON `case`.id=case_convict_info.case_id WHERE monthname(`case`.created_at)=month and case_convict_info.convict_gender='female') as female
     from `case` INNER JOIN case_convict_info ON `case`.id= case_convict_info.case_id WHERE year(`case`.created_at)=$year GROUP BY month(`case`.created_at)");


        $ConvictGenderData = [['Month', 'Male', 'Female']];
        foreach ($quryConvict as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (int)$value[2];
            $ConvictGenderData[] = $value ;
        }
       //return $ConvictGenderData;
        return view('admin.adminhome',compact('ConvictGenderData','dataCase','dataChargesheet','quryYear','caseIdData','quryYearCoart','quryYearInvestigation','quryYearChargesheet','dataInvestigation','dataCoart'));


    }

    public function selectCase($id){


        $qryCaseId = DB::table("case")
            ->select(DB::raw("MONTHNAME(created_at) as monthname"),DB::raw("(COUNT(*)) as total_case"), DB::raw('GROUP_CONCAT(reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->whereYear('created_at', '=', $id)
            ->get();




        foreach ($qryCaseId as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataCase[] = $value ;
        }




        return response()->json($dataCase);






    }

    public function selectCoart($id){
        $qryCoart = DB::table("case")
            ->join('coart_information', 'case.id', '=', 'coart_information.case_id')
            ->select(DB::raw("MONTHNAME(coart_information.created_at) as monthname"),DB::raw("(COUNT(*)) as total_coart"), DB::raw('GROUP_CONCAT(case.reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(coart_information.created_at)"))
            ->orderBy(DB::raw("MONTH(coart_information.created_at)"))
            ->whereYear('coart_information.created_at', '=', $id)
            ->get();




        foreach ($qryCoart as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataCoart[] = $value ;
        }
        return response()->json($dataCoart);





    }


    public function selectInvestigation($id){

        $qryInvestigation = DB::table("case")
            ->join('investigation_details', 'case.id', '=', 'investigation_details.case_number')
            ->select(DB::raw("MONTHNAME(investigation_details.created_at) as monthname"),DB::raw("(COUNT(*)) as total_case"), DB::raw('GROUP_CONCAT(case.reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(investigation_details.created_at)"))
            ->orderBy(DB::raw("MONTH(investigation_details.created_at)"))
            ->whereYear('investigation_details.created_at', '=', $id)
            ->get();




        foreach ($qryInvestigation as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataInvestigation[] = $value ;
        }

        return response()->json($dataInvestigation);





    }




    public function selectChargesheet($id){

        $qryChargesheet = DB::table("case")
            ->join('chargesheet_information', 'case.id', '=', 'chargesheet_information.case_id')
            ->select(DB::raw("MONTHNAME(chargesheet_information.created_at) as monthname"),DB::raw("(COUNT(*)) as total_case"), DB::raw('GROUP_CONCAT(case.reference_no) AS reference_no'))
            ->groupBy(DB::raw("MONTH(chargesheet_information.created_at)"))
            ->orderBy(DB::raw("MONTH(chargesheet_information.created_at)"))
            ->whereYear('chargesheet_information.created_at', '=', $id)
            ->get();




        foreach ($qryChargesheet as $v){
            $value = array_values((array)$v);
            $value[1] = (int)$value[1];
            $value[2] = (string)$value[2];
            $dataChargesheet[] = $value ;
        }
      //  return $arrayChargesheetMonth;
        return response()->json($dataChargesheet);





    }
  public function selectConvict($id){

      $quryConvict= DB::select("SELECT monthname(`case`.created_at)as month,
    (SELECT  count(case_convict_info.convict_gender) from case_convict_info
        INNER JOIN `case` ON `case`.id=case_convict_info.case_id WHERE monthname(`case`.created_at)=month and case_convict_info.convict_gender='male')  as male,
(SELECT  count(case_convict_info.convict_gender) from case_convict_info
        INNER JOIN `case` ON `case`.id=case_convict_info.case_id WHERE monthname(`case`.created_at)=month and case_convict_info.convict_gender='female') as female
     from `case` INNER JOIN case_convict_info ON `case`.id= case_convict_info.case_id WHERE year(`case`.created_at)=$id GROUP BY month(`case`.created_at)");


      $ConvictGenderData = [['Month', 'Male', 'Female']];
      foreach ($quryConvict as $v){
          $value = array_values((array)$v);
          $value[1] = (int)$value[1];
          $value[2] = (int)$value[2];
          $ConvictGenderData[] = $value ;
      }
      return response()->json($ConvictGenderData);






    }



    public function caseChartDetails($monthName,$year)
    {
        $month=(explode('-',$year));

        $year=$month[0];
        $month=$month[1];
        $data= DB::table("case")->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get();
        return view('admin.chart.caseChartDetails',compact('data'));




    }


}
