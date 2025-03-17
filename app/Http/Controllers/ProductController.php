<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');
        $products = Product::when($search, function($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('tagline', 'like', "%$search%");
        })->orderByDesc('id')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::transaction(function() use ($request){
            $validated = $request->validated();
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('files', 'public');
                $validated['file'] = $filePath;
            }

            $newProduct = Product::create($validated);
        });
        return redirect()->route('admin.products.index')->with('success', 'Product section added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function() use ($request, $product) {
                $validated = $request->validated();

                if ($request->hasFile('thumbnail')) {
                    if ($product->thumbnail && Storage::exists($product->thumbnail)) {
                        Storage::delete($product->thumbnail);
                    }

                    $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                    $validated['thumbnail'] = $thumbnailPath;
                }
                if ($request->hasFile('file')) {
                    if ($product->file && Storage::exists($product->file)) {
                        Storage::delete($product->file);
                    }

                    $filePath = $request->file('file')->store('files', 'public');
                    $validated['file'] = $filePath;
                }

                $product->update($validated);
            });

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(int $id)
    // {
    //     Product::destroy($id);
    //     return redirect()->route('admin.product.index')->with('success', 'Deleted Successfully');
    // }
    public function destroy(Product $product)
    {
        DB::transaction(function() use ($product) {
            $product->delete();
        });
        return redirect()->route('admin.products.index')->with('success', 'Deleted Successfully!' );
    }
}
