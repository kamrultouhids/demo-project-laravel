<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConvictNotArrestInfoDetailsModel extends Model
{
	protected $table = 'convict_not_arrest_information_details';
    protected $fillable = ['convict_not_arrest_information_id', 'name', 'description'];
    public $timestamps = false;
}
