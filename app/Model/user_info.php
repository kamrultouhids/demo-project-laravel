<?php

namespace App\Model;


use Illuminate\Foundation\Auth\User as Authenticatable;

class user_info extends Authenticatable
{
   protected $table = 'user_info';

   protected $hidden = [
       'password', 'remember_token',
   ];

   protected $fillable = [
       'name', 'email', 'password',
   ];
}
