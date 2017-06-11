<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class WitnessDetailsModel extends Model
{
    protected $table = 'witness_information_details';
    protected $fillable = ['id','fk_witness_id','witness_name','age','gender','father_name','mother_name','contact_no','profession','parmanent_address','present_address'];
    public $timestamps = false;

    public static function selectWitnessDetailsByid($id){
        $result = DB::table('witness_information_details')->where('fk_witness_id',$id)->get();
        return $result;
    }

}
