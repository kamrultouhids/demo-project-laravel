<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class WitnessModel extends Model
{
    use SoftDeletes;
    protected $table = 'witness';
    protected $fillable = ['id','case_id','date','created_by','witness_attach'];
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    public static function selectWitness(){
        $result = DB::table('witness')
            ->select('witness.*', 'case.reference_no')
            ->join('case', 'case.id', '=', 'witness.case_id')
            ->orWhereNull('witness.deleted_at')
            ->get();
        return $result;
    }
}
