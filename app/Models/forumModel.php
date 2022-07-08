<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class forumModel extends Model
{
    use HasFactory;

    protected $table = "forums";

    protected $fillable = ['classID','courseID','userID','chat'];
    public $timestamps = false;
}
