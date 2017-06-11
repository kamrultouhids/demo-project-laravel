<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ajaxController extends Controller
{
    public function getDistrict(Request $request)
    {
       $id=$request->divisionId;
        $districts = DB::table("districts")
            ->where("fk_division_id",$id)
            ->pluck('district_name','id');
        return json_encode($districts);
    }
    public function getDivisionWiseDistrict(Request $request)
    {
        $id=$request->divisionId;

        $districts = DB::table("districts")
            ->where("fk_division_id",$id)
            ->pluck('district_name','id');
        return json_encode($districts);
    }

    public function getDistrictWisePoliceStation(Request $request)
    {
        $id=$request->districtId;
        $policeStations = DB::table("police_stations")
            ->where("fk_district_id",$id)
            ->pluck('police_station_name','id');
        return json_encode($policeStations);
    }
    public function getEmployeeWiseDesignation(Request $request)
    {
        $id=$request->contactId;
        $result = DB::table('rab_employee')->where('id',$id)->first();
        echo json_encode($result);



    }
}
