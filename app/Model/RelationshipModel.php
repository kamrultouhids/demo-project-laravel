<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class RelationshipModel extends Model
{
    protected $table = 'relationship';
    protected $fillable = ['id', 'relationship_name'];

    public static function selectRelationship(){
        $result = DB::table('relationship')->select('*')->get();
        return $result;
    }

}
