<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseModel extends Model
{
    use HasFactory;

    protected $table = "courses";

    protected $fillable = ['teacherID','courseName','courseClass'];
    public $timestamps = false;
}
