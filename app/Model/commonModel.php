<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class commonModel extends Model
{
 

    public static function selectDivision(){
        $result = DB::table('divisions')->select('*')->get();
        return $result;
    }

    public static function selectDistrict(){
        $result = DB::table('districts')->select('*')->get();
        return $result;
    }

    public static function selectPoliceStation(){
        $result = DB::table('police_stations')->select('*')->get();
        return $result;
    }

    public static function selectBattalionList(){
        $result = DB::table('battalion')->select('*')->get();
        $options = [''=>'---- Please select ----'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->battalion_name;
        }
        return $options ;
    }

    public static function selectDesignationList(){
        $result = DB::table('designation')->select('*')->get();
        $options = [''=>'---- Please select ----'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->designation_name;
        }
        return $options ;
    }

    public static function selectRabEmployeeList(){
        $result = DB::table('rab_employee')->select('*')->get();
        $options = [''=>'--- Please select ---'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->employee_name;
        }
        return $options ;
    }

    public static function selectlawList(){
        $result = DB::table('law_section')->select('*')->get();
        $options = [''=>'--- Please select ---'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->section_name;
        }
        return $options ;
    }

    public static function selectCrimeTypeList(){
        $result = DB::table('crime_type')->select('*')->get();
        $options = [''=>'--- Please select ---'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->crime_type_name;
        }
        return $options ;
    }


    public static function CaseList(){
        $result = DB::table('case')->select('id', 'reference_no')->orWhereNull('deleted_at')->get();
        $options = [''=>'---- Please select ----'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->reference_no;
        }
        return $options;
    }
   
}
