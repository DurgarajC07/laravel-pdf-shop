<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function download(Product $product)
    {
        // Check if user has purchased this product
        $hasPurchased = auth()->user()->purchases()
            ->where('product_id', $product->id)
            ->where('is_confirmed', true)
            ->exists();

        if (!$hasPurchased) {
            return redirect()->route('products.show', $product)
                ->with('error', 'You need to purchase this product first!');
        }

        // Serve the file
        return Storage::download($product->file_path);
    }
}