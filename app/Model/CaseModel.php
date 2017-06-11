<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class CaseModel extends Model
{
    use SoftDeletes;

    protected $table = 'case';
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
}
