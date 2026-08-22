<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;
    protected $table = null;

    protected $hidden = ['password'];
}