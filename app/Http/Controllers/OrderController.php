<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\CartProduct;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $orders = Order::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        
        foreach ($orders as $order) {
            $order_products = DB::table('cart_product')
                ->join('products', 'cart_product.product_id', '=', 'products.id')
                ->where('cart_id', $order->cart_id)
                ->select('products.*', 'cart_product.qty')
                ->get();
            
            $order->order_products = $order_products;
        }
    
        return view('orders.index', compact('orders'));
    }
    
public function checkout()
{
    // Kontrolloni sesionin e përdoruesit për të verifikuar nëse ata janë kyqur
    if (!auth()->check()) {
        // Nëse përdoruesi nuk është kyqur, ridrejtojini në faqen e kyqjes
        return redirect()->route('login')->with('message', 'Ju duhet të kyqeni për të vazhduar me Checkout.');
    }

    // Merrni informacionin e përdoruesit të kyqur
    $user = auth()->user();

    // Shfaqni formën e regjistrimit të të dhënave për porosinë
    return view('checkout', compact('user'));
    
}
public function store(Request $request)
{
    $user_id = auth()->user()->id;
    $name = $request->input('name');
    $email = $request->input('email');

    // Krijimi i një objekti të ri Order duke përdorur modelin e Orders dhe ruajtja e tij në databazë
    $order = new Order;
    $order->name = $name;
    $order->email = $email;
    $order->user_id = $user_id;
    $order->save();

    // Merr ID-në e re të porosisë së krijuar
    $order_id = $order->id;

    // Kontrolloni nëse karta e përdoruesit ka produkte
$cart = Cart::where('user_id', $user_id)->first();
if ($cart) {
    // Merr të gjitha produktet në karta dhe shtoje në tabelën e produktit të porosisë
    $cart_products = CartProduct::where('cart_id', $cart->id)->get();
    $order_total = 0; // inicializohet totali i porosise
    foreach ($cart_products as $cart_product) {
        $order_product = new OrderProduct;
        $user_id = auth()->user()->id;
        $order_product->user_id = $user_id;
        $order_product->order_id = $order_id;
        $order_product->product_id = $cart_product->product_id;
        $order_product->qty = $cart_product->qty;
        $order_product->price = $cart_product->product->price;
        $order_product->save();

        // llogarit totalin e porosise
        $order_total += $cart_product->qty * $cart_product->product->price;
    }

    // Fshi produktet e karta pasi që porosia është kryer
    $cart->products()->detach();

    // Ruaj totalin e porosise ne database
    $order->total = $order_total;
    $order->save();

    // Ktheje përdoruesin në faqen e porosisë së krijuar
    return redirect()->route('orders.index', ['order' => $order_id])->with('status','Order was created sucsefuly');
}


    // Nëse karta e përdoruesit është bosh, ktheje përdoruesin në faqen e kartës me një mesazh gabimi
    return redirect()->route('cart.index')->with('error', 'Karta juaj është bosh!');



}   


}
