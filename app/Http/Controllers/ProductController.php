<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['images', 'category', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_visible', true)
            ->firstOrFail();

        $categories = Category::all();
        
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_visible', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'categories', 'relatedProducts'));
    }
}
