<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price', // Make sure 'price' is included in the $fillable array
        'stock_quantity',
        'image',
        'user_id'
    ];
    // Define the relationship between Product and Category models
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
