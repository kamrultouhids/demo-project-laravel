<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class BattalionModel extends Model
{
    protected $table = 'battalion';
    protected $fillable = ['id', 'fk_division_id','fk_district_id','fk_police_station_id','battalion_name','battalion_address','contact_person_name','designation','contact_no'];

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
    public static function selectBattalion(){
        $result = DB::table('battalion')
            ->select('battalion.*', 'divisions.division_name','districts.district_name','police_stations.police_station_name')
            ->join('divisions', 'divisions.id', '=', 'battalion.fk_division_id')
            ->join('districts', 'districts.id', '=', 'battalion.fk_district_id')
            ->join('police_stations', 'police_stations.id', '=', 'battalion.fk_police_station_id')
            ->get();
        return $result;
    }
    public static function selectRabEmployeeList(){
        $result = DB::table('rab_employee')->select('*')->get();
        return $result;
    }
}
