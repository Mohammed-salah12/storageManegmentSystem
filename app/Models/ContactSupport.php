<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSupport extends Model
{
    use HasFactory;

    protected $fillable= [
        'name' , 'email' , 'massage' , 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
