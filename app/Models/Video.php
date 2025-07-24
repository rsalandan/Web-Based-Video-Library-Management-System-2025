<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'description',
        'video',     // Add url to fillable so mass assignment works if needed
        'thumbnail',
        'status',
        'views',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function viewers()
    {
        return $this->hasMany(VideoViewer::class, 'video_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'video_likes')->withTimestamps();
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'video_user_plays')
            ->withPivot('played_at');
    }
}
