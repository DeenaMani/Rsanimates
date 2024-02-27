<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    public $timestamps = false;
    protected $table = 'about';
    protected $guarded = ['id'];

}