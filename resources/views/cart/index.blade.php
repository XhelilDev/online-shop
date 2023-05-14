@extends('layouts.app')

@section('content')
    <h1>Cart</h1>
  
    @if ($cart_products->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Vlera</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart_products as $cart_product)
                    <tr>
                        <td>{{ $cart_product->name }}</td>
                        <td>{{ $cart_product->pivot->qty }}</td>
                        <td>${{ $cart_product->price }}</td>
                        <td>${{ $cart_product->price * $cart_product->pivot->qty }}</td>
                        <td>
                        <form action="{{ route('cart.remove', ['product_id' => $cart_product->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    </tr>
                    @php $total += $cart_product->price * $cart_product->pivot->qty; @endphp
                    @endforeach
              
                    <tr>
                    <td><strong>Total:</strong></td>
                    <td></td>
                    <td></td>
                    <td>${{ $total }}</td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="cart_items" value="{{$cart_products }}">

        <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>

    @else
        <p>Your cart is empty.</p>
    @endif
@endsection
