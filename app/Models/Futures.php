<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Futures extends Model
{
	protected $table = 'futures';
    protected $fillable = [ 'heading','description','image_name','futures_status'];
}