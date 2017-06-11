<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConvictArrestInfo extends Model
{
	use SoftDeletes;
    
    protected $table = 'convict_arrest_information';
    protected $fillable = ['case_id', 'date', 'attach'];
    protected $softDelete = true;

}

