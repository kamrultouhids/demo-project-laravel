<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class userPermissionModel extends Model
{
    protected $primaryKey = 'permission_id';
    protected $table = 'user_permission';
    public $timestamps = false;
    protected $fillable = [ 'role_id', 'menu_id'];
}
