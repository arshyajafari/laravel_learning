<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get (Request $request)
    {
        $eloquent = (new ProductModel())->with('categories');

        $queries = $request->validate([
            'category_id' => ['string', 'max:20']
        ]);

        if (isset($queries['category_id']))
        {
            // $eloquent = $eloquent->where('category_id', $queries['category_id']);
            $eloquent = $eloquent->whereHas('categories', function ($query) use ($queries)
            {
                $query->where('categories.id', $queries['category_id']);
            });
        }

        return response()->json(
            ProductResource::collection($eloquent->get())
        );
    }

    public function getById (string $id)
    {
        $entity = ProductModel::with('categories')->where('id', $id)->first();

        if (empty($entity))
        {
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }

        return response()->json(
            new ProductResource($entity)
        );
    }
}
