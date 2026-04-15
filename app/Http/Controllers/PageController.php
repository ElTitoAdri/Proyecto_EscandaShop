<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PageController extends Controller
{
    public function about()
    {
        $categories = Category::all();
        return view('welcome', compact('categories'));
    }
}
