<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class CrimeTypeModel extends Model
{
    protected $table = 'crime_type';
    protected $fillable = ['id', 'crime_type_name'];
    //public $timestamps = false;

    public static function selectCrimeType(){
        return DB::table('crime_type')->select('*')->get();
    }
}
