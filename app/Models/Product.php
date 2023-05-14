<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','qty','price','image'
    ];
    

    public function categories(){
        return $this->hasOne(Product::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function cart(){
        return $this->belongdToMany(Cart::class);
    }

  
    
    
}
