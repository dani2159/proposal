<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    protected $table = 'ormawa';
    public $remember_token = false;
    protected $guarded = [];
}
