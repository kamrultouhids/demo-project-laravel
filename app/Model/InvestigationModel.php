<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class InvestigationModel extends Model
{

    use SoftDeletes;
    protected $table = 'investigation_details';
    protected $fillable = ['id', 'investigation_date', 'case_number','investigation_details','investigation_attach','investigation_by'];
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    //protected $dates = ['investigation_date']
    //public $timestamps = false;

        public static function selectInvestigation()
        {

            return DB::table('investigation_details')->orWhereNull('deleted_at')->select('*')->get();
    	
         }
   
}
