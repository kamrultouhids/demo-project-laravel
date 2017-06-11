<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class PoliceStationModel extends Model
{
    protected $table = 'police_stations';
    protected $fillable = ['id', 'fk_division_id','fk_district_id','police_station_name'];

    public static function selectDivision(){
        $result = DB::table('divisions')->select('*')->get();
        return $result;
    }
    public static function selectDistrict(){
        $result = DB::table('districts')->select('*')->get();
        return $result;
    }
    public static function selectPoliceStation(){
        $result = DB::table('police_stations')
            ->select('police_stations.*', 'divisions.division_name','districts.district_name')
            ->join('divisions', 'divisions.id', '=', 'police_stations.fk_division_id')
            ->join('districts', 'districts.id', '=', 'police_stations.fk_district_id')
            ->get();
        return $result;
    }

}
