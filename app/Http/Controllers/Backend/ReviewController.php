<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'video_id' => 'required|exists:videos,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    Review::create([
        'user_id' => auth()->id(),
        'video_id' => $request->video_id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return back()->with('success', 'Review submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
 $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    $review = Review::findOrFail($id);

    // Optionally, check if the authenticated user owns the review or has permission
    if (Auth::id() !== $review->user_id && !Auth::user()->can('video.create')) {
        abort(403, 'Unauthorized');
    }

    $review->comment = $request->comment;
    $review->rating = $request->rating;
    $review->save();

    return redirect()->back()->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
 $review = Review::findOrFail($id);

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
