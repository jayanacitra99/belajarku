<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignmentModel extends Model
{
    use HasFactory;

    protected $table = "assignments";

    protected $fillable = ['courseID', 'classID', 'title', 'description', 'type', 'files', 'link', 'start_date', 'end_date', 'voice', 'image', 'question', 'answer'];
}
