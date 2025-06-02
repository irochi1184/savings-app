<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'category',
        'note',
        'earned_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}