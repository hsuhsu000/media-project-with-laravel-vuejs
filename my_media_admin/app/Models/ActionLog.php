<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = ['actionLogs_id', 'user_id', 'post_id'];
    use HasFactory;
}
