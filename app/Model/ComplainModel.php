<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ComplainModel extends Model
{

    use SoftDeletes;
    protected $table = 'complain_info';
    protected $fillable = ['id', 'date', 'reference_no','investigation_details','battalion'];
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    //protected $dates = ['investigation_date']
    //public $timestamps = false;

    public static function selectComplain()
    {

        return DB::table('complain_info')->orWhereNull('deleted_at')->select('*')->get();

    }

}
