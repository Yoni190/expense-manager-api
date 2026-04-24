<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();

        $categories = $user->categories()->latest()->get();

        return response()->json([
            'data' => $categories
        ], 200);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255|unique:categories'
        ]);

        $category = $request->user()->categories()->create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);

    }

    public function update(Request $request, Category $category) {

        if($category->user_id !== $request->user()->id) {
            return response()->json([ 'message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255|unique:categories'
        ]);

        $category->update($validated);

        return response()->json([ 'message' => 'Category Updated', 'data' => $category ]);
    }
}
