<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['transaction_type', 'product_id', 'location_id', 'quantity', 'transaction_date', 'notes', 'user_id'];

    // Define the relationship between Transaction and Product models
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship between Transaction and Location models
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
