<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoartInfoModel extends Model
{
    use SoftDeletes;

    protected $table = 'coart_information';
    protected $fillable = ['case_id', 'date','coart_name','judge_name','judgment','coart_attach'];
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
}
