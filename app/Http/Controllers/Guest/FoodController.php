<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Category;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categorySlug = $request->query('category');

        $queryFood = Food::with('category')->orderBy('name');

        if ($search) {
            $queryFood->where('name', 'like', '%' . $search . '%');
        }

        if ($categorySlug) {
            $queryFood->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $foods = $queryFood->paginate(9);
        $categories = Category::orderBy('name')->get();

        return view('guest.foods.index', compact('foods', 'categories'));
    }
}
