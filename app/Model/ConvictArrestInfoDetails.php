<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConvictArrestInfoDetails extends Model
{
    
    protected $table = 'convict_arrest_information_details';
    protected $fillable = ['convict_arrest_information_id', 'name', 'place', 'legal_goods_seized', 'illegal_goods_seized'];
    public $timestamps = false;



}

