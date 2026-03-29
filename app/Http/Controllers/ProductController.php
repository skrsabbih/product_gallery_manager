<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            // Create the product
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            // Create product images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = Storage::disk('public')->putFile('products', $image);
                    $product->images()->create([
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the product.');
        }
    }

    public function show(Product $product)
    {
        $product->load('images');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        // update product data
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            // remove old images
            if (!empty($validated['remove_images'])) {
                $imagesToRemove = $product->images()
                    ->whereIn('id', $validated['remove_images'])
                    ->get();

                foreach ($imagesToRemove as $productImage) {
                    if (!empty($productImage->image_path) && Storage::disk('public')->exists($productImage->image_path)) {
                        Storage::disk('public')->delete($productImage->image_path);
                    }

                    $productImage->delete();
                }
            }

            // add new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // update product images path
                    $path = Storage::disk('public')->putFile('products', $image);

                    // update product images adding new images
                    $product->images()->create([
                        'image_path' => $path,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong.');
        }
    }

    public function destroy(Product $product)
    {
        // relation with images 
        $product->load('images');
        // delete product images from storage and database
        foreach ($product->images as $image) {
            if (!empty($image->image_path) && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }
        // delete product
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
