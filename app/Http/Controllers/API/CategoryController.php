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
}
