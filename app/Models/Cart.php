<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
  
    protected $table = 'cart';

    protected $fillable = [
        'cart_id',
        'product_id',
        'total',
        'qty',
    ];
    public function products(){
        return $this->belongsToMany(Product::class);
            return $this->belongsToMany(Product::class, 'cart_product')->withPivot('qty')->withTimestamps()->withDefault(['qty' => 1]);

    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function order()
{
    return $this->belongsTo(Order::class);
}

}
