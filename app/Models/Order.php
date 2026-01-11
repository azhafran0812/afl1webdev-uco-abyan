<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'shipping_address',
        'payment_method',
    ];

    // Relasi ke User (Agar $order->user->name bisa jalan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderItem (Agar foreach $order->items bisa jalan)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
