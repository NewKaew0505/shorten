<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination',
        'title',
        'domain',
        'backhalf'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
