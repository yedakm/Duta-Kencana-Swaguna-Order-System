<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Food;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function memberIndex(Request $request)
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
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
        return view('user.foods.index', compact('foods', 'categories', 'orders'));
    }
    
    /**
     * Show the form for ordering food.
     */
    public function order(Request $request)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
