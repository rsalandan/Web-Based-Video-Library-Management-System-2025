<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Category;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $viewMode = $request->get('view', 'grid'); // default to 'grid'

        $query = Video::with('category')
            ->withCount(['viewers', 'likes', 'reviews'])  // Include reviews count here
            ->withAvg('reviews', 'rating')
            ->where('status', 1);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('views')) {
            $query->orderBy('viewers_count', $request->views);
        } elseif ($request->filled('likes')) {
            $query->orderBy('likes_count', $request->likes);
        } elseif ($request->filled('rating')) {
            $query->orderBy('reviews_avg_rating', $request->rating);
        } else {
            $query->latest();
        }

        $videos = $query->paginate(6)->appends($request->except('page'));

        $categories = Category::all();

        return view('backend.video.index', compact('videos', 'categories', 'viewMode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $videos = Video::all();
        $categories = Category::all();
        return view('backend.video.create', compact('categories', 'videos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'required|string|max:65535',
            'video' => 'required|mimes:mp4|max:31200', // 30MB in KB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048', // 1MB
        ], [
            'video.required' => 'Please choose a video file.',
            'video.mimes' => 'Only MP4 video files are allowed.',
            'video.max' => 'The video file must not be greater than 30MB.',

            'thumbnail.image' => 'The thumbnail must be an image.',
            'thumbnail.mimes' => 'Allowed thumbnail formats: jpeg, png, jpg, gif.',
            'thumbnail.max' => 'The thumbnail file must not be greater than 1MB.',
        ]);

        // Store video file
        $videoFile = $request->file('video');
        $videoName = time() . '_' . $videoFile->getClientOriginalName();
        $videoFile->move(public_path('upload/video'), $videoName);
        $videoPathDb = 'upload/video/' . $videoName;

        // Store thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('upload/thumbnail'), $thumbnailName);
            $thumbnailPathDb = 'upload/thumbnail/' . $thumbnailName;
        } else {
            $thumbnailPathDb = 'upload/thumbnail/default-thumbnail.jpg';
        }

        // Save to database
        $video = new Video();
        $video->title = $request->title;
        $video->slug = Str::slug($request->title);
        $video->category_id = $request->category_id;
        $video->description = $request->description;
        $video->video = $videoPathDb;
        $video->thumbnail = $thumbnailPathDb;
        $video->status = 1;
        $video->save();

        return redirect()->route('video.index')->with([
            'message' => 'Video Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = Video::with(['category', 'reviews.user', 'likes'])->findOrFail($id);

        if (Auth::check()) {
            DB::table('video_user_plays')->insert([
                'user_id' => Auth::id(),
                'video_id' => $video->id,
                'played_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get distinct recent videos for the user (latest 4)
        $recentVideoIds = DB::table('video_user_plays')
            ->select('video_id', DB::raw('MAX(played_at) as last_played'))
            ->where('user_id', Auth::id())
            ->groupBy('video_id')
            ->orderByDesc('last_played')
            ->limit(4)
            ->pluck('video_id');

        $recentPlays = Video::whereIn('id', $recentVideoIds)
            ->orderByRaw("FIELD(id, " . implode(',', $recentVideoIds->toArray()) . ")")
            ->get();

        return view('backend.video.show', compact('video', 'recentPlays'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::findOrFail($id);
        $categories = Category::all();
        return view('backend.video.edit', compact('video', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = Video::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'required|string|max:65535',
            'video' => 'required|mimes:mp4|max:31200', // 30MB in KB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048', // 1MB
        ], [
            'video.required' => 'Please choose a video file.',
            'video.mimes' => 'Only MP4 video files are allowed.',
            'video.max' => 'The video file must not be greater than 30MB.',

            'thumbnail.image' => 'The thumbnail must be an image.',
            'thumbnail.mimes' => 'Allowed thumbnail formats: jpeg, png, jpg, gif.',
            'thumbnail.max' => 'The thumbnail file must not be greater than 1MB.',
        ]);

        $video->title = $request->title;
        $video->slug = Str::slug($request->title);
        $video->category_id = $request->category_id;
        $video->description = $request->description;

        // If new video is uploaded
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoName = time() . '_' . $videoFile->getClientOriginalName();
            $videoFile->move(public_path('upload/video'), $videoName);
            $video->video = 'upload/video/' . $videoName;
        }

        // If new thumbnail is uploaded
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('upload/thumbnail'), $thumbnailName);
            $video->thumbnail = 'upload/thumbnail/' . $thumbnailName;
        }

        $video->save();

        return redirect()->route('video.index')->with('message', 'Video Updated Successfully');
    }

    // Optional: destroy (if needed)
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect()->route('video.index')->with('message', 'Video Deleted Successfully');
    }


    public function trackView(Request $request, $id)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $video = Video::findOrFail($id);

        // Insert a new record for this view
        DB::table('video_views')->insert([
            'video_id' => $video->id,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Increment the total views count on the video model
        $video->increment('views');

        return response()->json(['success' => true]);
    }

    public function recentlyPlayed()
    {
        $recentPlays = Auth::user()->recentlyPlayedVideos()->paginate(10);
        return view('videos.recent', compact('recentPlays'));
    }
}
