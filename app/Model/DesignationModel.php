<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class DesignationModel extends Model
{
    protected $table = 'designation';
    protected $fillable = ['id', 'designation_name','created_by','updated_by'];

    public static function selectDesignation(){
        $result = DB::table('designation')->select('*')->get();
        return $result;
    }
}
