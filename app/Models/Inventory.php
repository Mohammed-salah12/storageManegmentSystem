<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['product_id', 'location_id', 'quantity', 'last_stock_update', 'user_id'];

    // Define the relationship between Inventory and Product models
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship between Inventory and Location models
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
