<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoViewer extends Model
{
    use HasFactory;
    protected $table = 'video_views';  // Use the actual table name here
}
