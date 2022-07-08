<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classModel extends Model
{
    use HasFactory;

    protected $table = "classes";

    protected $fillable = ['class','indexClass','quota'];
    public $timestamps = false;
}
