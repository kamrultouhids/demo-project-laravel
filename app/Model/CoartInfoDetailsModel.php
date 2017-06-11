<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CoartInfoDetailsModel extends Model
{
    protected $table = 'coart_information_details';
    protected $fillable = ['coart_info_id', 'name', 'description'];
    public $timestamps = false;
}
