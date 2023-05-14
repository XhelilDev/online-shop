<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products=Product::all();

        return view('products.index',[
            'products'=>$products
        ]);
    }



    public function showLatestProducts()
{
    $latestProducts = Product::orderBy('created_at', 'desc')->take(10)->get(); //merr 10 produktet e fundit në bazë të kohës së krijimit
    return view('home', compact('latestProducts'));

    
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        if($request->hasfile('image')) {
            $file = $request['image']->getClientOriginalName();
            $image = time() ."_" .pathinfo($file, PATHINFO_FILENAME) ."." .pathinfo($file, PATHINFO_EXTENSION);
            $data['image'] = $image;
            Storage::putFileAs('public/products/', $request['image'], $image);
        }

        if(Product::create($data)) {
            return redirect()->route('products.index')->with('status', 'Product was created sucessfully.');
        } else {
            return back()->with('error', 'Something want wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        if(!Auth::user()->hasPermissionTo('edit product')){
            return redirect()->route('dashboard')->with('status','You dont have permission to perform this action');
        }

        $product=Product::findOrFail($id);
        return view('products.edit',[
            'product'=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!Auth::user()->hasPermissionTo('edit product')){
            return redirect()->route('dashboard')->with('status','You dont have permission to perform this action');
        }

        $product = Product::findOrFail($id);
        $product->name = $request['name'];
        $product->qty = $request['qty'];
        $product->price = $request['price'];

        if($request->hasfile('image')) { 
            $file = $request['image']->getClientOriginalName();
            $image = time() ."_" .pathinfo($file, PATHINFO_FILENAME) ."." .pathinfo($file, PATHINFO_EXTENSION);
            $product->image = $image;
            Storage::putFileAs('public/products/', $request['image'], $image);
        }

        if($product->save()) {
            return redirect()->route('products.index')->with('status', 'Product was updated sucessfully.');
        } else {
            return back()->with('error', 'Something want wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        if(!Auth::user()->hasPermissionTo('edit product')){
            return redirect()->route('dashboard')->with('status','You dont have permission to perform this action');
        }

        $product=Product::findOrFail($id);

        if($product->delete()){
            return redirect()->route('products.index')->with('status','Product was deleted sucessfully');
        } else{
            return back()->with('error','Something went wrong!');
        }
    }
    public function cart()
    {
        return view('cart');
    }
public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['qty'] = $request->qty;
    }  else {
        $cart[$id] = [
            "product_name" => $product->name,
            "photo" => $product->image,
            "price" => $product->price,
            "qty" => $request->qty
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product add to cart successfully!');
}

public function search(Request $request)
{
    $query = $request->input('query');

    $results = Product::where('name', 'like', '%'.$query.'%')->get();

    return view('search-results', compact('results'));
}

}
