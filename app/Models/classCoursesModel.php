<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classCoursesModel extends Model
{
    use HasFactory;

    protected $table = "classcourses";

    protected $fillable = ['classID','courseID'];
    public $timestamps = false;
}
