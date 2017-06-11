<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargeSheetModel extends Model
{
	use SoftDeletes;
    
    protected $table = 'chargesheet_information';
    protected $fillable = ['case_id', 'date','chargesheet_attach'];
    protected $softDelete = true;


    public static function boot() {
        parent::boot();

        static::updating(function($table)  {
            $table->modified_by = 1;
        });

        // static::deleting(function($table)  {
        //     $table->deleted_by = Auth::user()->username;
        // });

        static::creating(function($table)  {
            $table->created_by = 1;
        });
	}


}
