@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($cart && $cart->products)
                    @foreach($cart->products as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->price}}</td>
                            <td>1</td>
                            <td>{{$product->price}}</td>
                            <td>
                                <!-- <a href="{{route('removeFromCart', $product->id)}}" class="btn btn-danger">Remove</a> -->
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Your shopping cart is empty.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <!-- <a href="{{route('checkout')}}" class="btn btn-primary">Proceed to Checkout</a> -->
    </div>
@endsection
