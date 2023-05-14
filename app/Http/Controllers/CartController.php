<?php

namespace App\Http\Controllers;



use App\Models\Cart;
use App\Models\Product;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Merr shportën aktuale për përdoruesin aktuale
    $cart = Cart::where('user_id', Auth::user()->id)->first();

    // Nëse shporta nuk ekziston, krijoni një të re
    if (!$cart) {
        $cart = new Cart;
        $cart->user_id = Auth::user()->id;
        $cart->save();
    }

    // Merr produktet në shportë nga tabela pivot "cart_product"
    $cart_products = $cart->products;
    $cart_products = $cart->products()->withPivot('qty')->get();


    // Ktheje shportën dhe produktet në faqen "cart.index"
    return view('cart.index', [
        'cart' => $cart,
        'cart_products' => $cart_products,
    ]);

  

    }

    
    
    
    

    /**
     * Show the form for creatinsg a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
       //
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addToCart(Request $request, $product_id)
    {
        $product = Product::find($product_id);
    
        if (!$product) {
            return redirect()->back()->withErrors('Product not found.');
        }
    
        $cart = Cart::where('user_id', auth()->id())->first();
    
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = auth()->id();
            $cart->save();
        }
    
        $qty = $request->input('qty'); // merr vlerën e 'qty' nga kërkesa (request)
        $total = $qty * $product->price;
    
        $existing_cart_item = CartProduct::where('cart_id', $cart->id)->where('product_id', $product_id)->first();
    
        if ($existing_cart_item) {
            $existing_cart_item->qty += $qty;
            $existing_cart_item->total = $existing_cart_item->qty * $product->price;
            $existing_cart_item->save();
        } else {
            $cart->products()->attach($product_id, ['qty' => $qty, 'total' => $total]); // shtoni 'total' këtu
            $cart->total += $total;
            $cart->save();
        }
    
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }
    

public function removeProduct($product_id)
{
    $cart = Cart::where('user_id', auth()->id())->first();
    $cart_product = CartProduct::where('cart_id', $cart->id)->where('product_id', $product_id)->first();

    if ($cart_product) {
        $cart_product->delete();
        $cart->total -= $cart_product->price * $cart_product->qty;
        $cart->save();
        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    } else {
        return redirect()->back()->withErrors('Product not found in cart.');
    }
}
public function showCart()
{
    $cart_products = auth()->user()->products()->wherePivot('qty', '>', 0)->get();
    return view('cart', compact('cart_products'));
}


}