<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class RabEmployeeModel extends Model
{
    protected $table = 'rab_employee';
    protected $fillable = ['id', 'employee_no','employee_name','gender','contact_no','employee_image','fk_battalion_id','fk_designation_id','created_by','updated_by'];

    public static function selectRabEmployeeInfo(){
        $result = DB::table('rab_employee')
            ->select('rab_employee.*', 'designation.designation_name','battalion.battalion_name')
            ->join('designation', 'designation.id', '=', 'rab_employee.fk_designation_id')
            ->join('battalion', 'battalion.id', '=', 'rab_employee.fk_battalion_id')
            ->get();
        return $result;
    }
}
