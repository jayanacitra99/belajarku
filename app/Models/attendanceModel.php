<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendanceModel extends Model
{
    use HasFactory;

    protected $table = "attendancelog";

    protected $fillable = ['studentID','time'];
    public $timestamps = false;
}
