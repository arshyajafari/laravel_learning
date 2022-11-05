<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get ()
    {
        return response()->json(
            CategoryResource::collection(CategoryModel::with('products')->get())
        );
    }
}
