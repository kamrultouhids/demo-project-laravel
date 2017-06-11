<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class LawSectionModel extends Model
{
    protected $table = 'law_section';
    protected $fillable = ['id', 'section_name','section_description'];

    public static function selectLawSection(){
        $result = DB::table('law_section')->select('*')->get();
        return $result;
    }
}
