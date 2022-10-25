<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        "title",
        "description"
    ];

    /*
    public function products ()
    {
        return $this->hasMany(ProductModel::class, 'category_id', 'id');
    }
    */

    public function products ()
    {
        return $this->belongsToMany(ProductModel::class, 'category_product', 'category_id', 'product_id');
    }
}
