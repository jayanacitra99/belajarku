<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignmentLogModel extends Model
{
    use HasFactory;

    protected $table = "assignmentlog";

    protected $fillable = ['assignmentID','studentID','answer','grade','files','created_at'];
}
