<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'type',
        'currency',
        'description',
        'idempotency_key',
        'user_id',
        'category_id',
        'transaction_date'
    ];

    public function category() {
        return $this->hasOne(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
