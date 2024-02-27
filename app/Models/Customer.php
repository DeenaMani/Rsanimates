<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customer';
    protected $fillable = [ 'first_name','last_name','dob','email','password','mobile','gender','profile_image','city','app_id','status','otp'];
}
