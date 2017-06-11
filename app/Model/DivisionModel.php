<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class DivisionModel extends Model
{
    protected $table = 'divisions';
    protected $fillable = ['id', 'division_name'];

    public static function selectDivision(){
        return DB::table('divisions')->select('*')->get();
    }
}

