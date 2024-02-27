<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	protected $table = 'banner';
    protected $fillable = [ 'banner_image','banner_name','banner_description','banner_status','banner_link'];
}