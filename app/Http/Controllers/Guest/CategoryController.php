<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('foods')->paginate(9);
        return view('guest.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $foods = $category->foods()->paginate(9);
        return view('guest.categories.show', compact('category', 'foods'));
    }
}
