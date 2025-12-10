<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('category')->paginate(9);
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['name']);
        $validated['slug'] = $slug;

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = $slug . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('foods', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        Food::create($validated);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item created successfully');
    }

    public function edit(Food $food)
    {
        $categories = Category::all();
        return view('admin.foods.edit', compact('food', 'categories'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['name']);
        $validated['slug'] = $slug;

        if ($request->hasFile('image')) {
            if ($food->image && Storage::disk('public')->exists($food->image)) {
                Storage::disk('public')->delete($food->image);
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = $slug . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('foods', $imageName, 'public');
            $validated['image'] = $imagePath;
        }
        $food->update($validated);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item updated successfully');
    }

    public function destroy(Food $food)
    {
        if ($food->image) {
            Storage::disk('public')->delete($food->image);
        }

        $food->delete();

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item deleted successfully');
    }
}
