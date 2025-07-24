<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::latest()->get();
        return view('backend.product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $brands = Brand::all();
        return view('backend.product.create', compact('categories','sub_categories','brands', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'brand_id' => 'required|exists:brands,id',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
                'qty' => 'required|integer|min:0',
                'sku' => 'nullable|string|max:255',
                'receiving_date' => 'required|date',
            ]);
    
            // Generate product code
            $pcode = 'PROD-' . Str::upper(Str::random(7));
    
            // Handle photo upload
            $photo = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('upload/product'), $name_gen);
            $save_url = 'upload/product/' . $name_gen;
    
            // Create product
            Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'brand_id' => $request->brand_id,
                'code' => $pcode,
                'description' => $request->description,
                'qty' => $request->qty,
                'sku' => $request->sku,
                'receiving_date' => $request->receiving_date,
                'photo' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            // Success Notification
            return redirect()->route('product.index')->with([
                'message' => 'Product Created Successfully',
                'alert-type' => 'success'
            ]);
    
        } catch (\Exception $e) {
            // Error Notification
            return redirect()->back()->withInput()->with([
                'message' => 'Failed to create product: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the specific product by ID
        $product = Product::findOrFail($id);
    
        // Fetch other necessary data
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $brands = Brand::all();
    
        // Generate QR code for the product code or any other field
        $qrCode = QrCode::size(150)->generate($product->code); // Use $product instead of $products
    
        // Pass the qrCode and product data to the view
        return view('backend.product.show', compact('categories', 'sub_categories', 'brands', 'product', 'qrCode'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $brands = Brand::all();
        return view('backend.product.edit', compact('categories', 'sub_categories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'sub_category_id' => 'required|exists:sub_categories,id', // Ensure sub_category_id is valid
            'brand_id' => 'required|exists:brands,id', // Ensure brand exists
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Make photo optional during update
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'receiving_date' => 'required|date',
        ]);
        
        // Find the product to update
        $product = Product::findOrFail($id);
        
        // Check if a new photo is uploaded
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if (file_exists(public_path($product->photo))) {
                unlink(public_path($product->photo));
            }
            
            // Handle new photo upload
            $photo = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('upload/product'), $name_gen);
            $save_url = 'upload/product/' . $name_gen;
            
            // Update the product with the new photo path
            $product->photo = $save_url;
        }
        
        // Update the product record in the database
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,  // Ensure this is not null
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'qty' => $request->qty,
            'sku' => $request->sku,
            'receiving_date' => $request->receiving_date,
            'updated_at' => Carbon::now(),
        ]);
        
        // Return a success notification and redirect back
        $notification = [
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        ];
        
        return redirect()->route('product.index')->with($notification);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $img = $product->photo;
        if (file_exists($img)) {
            unlink($img);
        }

        $product->delete();

        $notification = [
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * Get Subcategories by Category ID (AJAX).
     */
    // Controller Method Example
        public function getSubCategories(Request $request)
        {
            $categoryId = $request->id;
            if ($categoryId) {
                $subcategories = SubCategory::where('category_id', $categoryId)->get();
                return response()->json($subcategories);
            }

            return response()->json([]);
        }
}