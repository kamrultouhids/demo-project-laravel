<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChargeSheetDetailsModel extends Model
{
    
    protected $table = 'chargesheet_information_details';
    protected $fillable = ['chargesheet_information_id', 'convict_name', 'convict_age', 'convict_gender', 'convict_father_name', 'convict_mother_name', 'convict_contact_number', 'convict_permanent_address', 'convict_present_address', 'convict_pastcase', 'convict_details'];
    public $timestamps = false;
}
