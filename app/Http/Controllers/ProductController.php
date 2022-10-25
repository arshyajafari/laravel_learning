<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get (Request $request)
    {
        $eloquent = new ProductModel();

        $queries = $request->validate([
            'category_id' => ['string', 'max:20']
        ]);

        if (isset($queries['category_id']))
        {
            $eloquent = $eloquent->where('category_id', $queries['category_id']);
        }

        return response()->json(
            $eloquent->get()
        );
    }
}