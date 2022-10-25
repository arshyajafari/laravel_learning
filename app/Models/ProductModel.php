<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        "title",
        "description",
        "price",
        "image",
        "category_id"
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, "category_id", "id");
    }

    public function categories ()
    {
        return $this->belongsToMany(CategoryModel::class, 'category_product', 'product_id', 'category_id');
    }
}
