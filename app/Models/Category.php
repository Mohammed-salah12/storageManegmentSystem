<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name' , 'user_id'];

    // Define the relationship between Category and Product models
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
