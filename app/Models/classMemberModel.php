<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classMemberModel extends Model
{
    use HasFactory;

    protected $table = "classmember";

    protected $fillable = ['classID','studentID'];
    public $timestamps = false;
}
