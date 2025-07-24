<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Video;
use App\Models\SubCategory;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::latest()->get();
         $videos = Video::all(); // fetch all videos
        return view('backend.category.index', compact('category', 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.index')->with($notification);  
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
                $category = Category::findOrFail($id);
                return view('backend.category.edit', compact('category'));
            }

        /**
         * Update the specified resource in storage.
         */
            public function update(Request $request, string $id)
            {
            // Validate input
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Find the category
            $category = Category::findOrFail($id);

            // Update category fields
            $category->name = $request->name;
            $category->save();

            // Redirect with success message
            return redirect()->route('category.index')->with('success', 'Category updated successfully.');
        }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(string $id)
        {
                Category::findOrFail($id)->delete();

                $notification = array(
                    'message' => 'Category Deleted Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
        }

    /**
     * Change the status of the specified category (AJAX).
     */
    public function changeStatus(Request $request)
        {
            $category = Category::findOrFail($request->id);
            $category->status = $request->status == 'true' ? 1 : 0;
            $category->save();

            return response(['message' => 'Status has been updated!']);
        }
}