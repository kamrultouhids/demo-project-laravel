<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use DB;

class DistrictModel extends Model
{
    protected $table = 'districts';
    protected $fillable = ['id', 'fk_division_id','district_name'];

    public static function selectDivision(){
        $result = DB::table('divisions')->select('*')->get();
        return $result;
    }
    public static function selectDistrict(){
        $result = DB::table('districts')
            ->select('districts.*', 'divisions.division_name')
            ->join('divisions', 'divisions.id', '=', 'districts.fk_division_id')
            ->get();
        return $result;
    }
}
