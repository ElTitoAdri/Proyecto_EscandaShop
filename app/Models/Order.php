<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price', 'status', 'shipping_address', 'payment_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function booted()
    {
        static::updated(function ($order) {
            if ($order->isDirty('status')) {
                try {
                    \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdated($order));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Error al enviar email de cambio de estado de pedido: " . $e->getMessage());
                }
            }
        });
    }
}
