<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;



class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_address',
        'user_id',
        'status',
        'session_id',
    ];
    const STATUS = [
        'paid' => 'paid',
        'unpaid' => 'unpaid',
    ];
    protected function shippingAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
    public function getTotalAmountAttribute()
    {
        return $this->orderItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}
