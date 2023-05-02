<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    //no updated_at and created_at columns in this table
    public $timestamps = false;

    //no id in this table
    protected $primaryKey = 'name';
}
