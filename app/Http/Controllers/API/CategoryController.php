<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
