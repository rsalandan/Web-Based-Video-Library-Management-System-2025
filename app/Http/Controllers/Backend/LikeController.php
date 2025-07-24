<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function toggleLike(Video $video)
    {
        $user = Auth::user();

        if ($video->likes()->where('user_id', $user->id)->exists()) {
            $video->likes()->detach($user->id);
            $liked = false;
        } else {
            $video->likes()->attach($user->id);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $video->likes()->count()
        ]);
    }
}
