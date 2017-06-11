<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConvictNotArrestInfoModel extends Model
{
	use SoftDeletes;
    
    protected $table = 'convict_not_arrest_information';
    protected $fillable = ['case_id', 'date', 'attach'];
    protected $softDelete = true;
}
