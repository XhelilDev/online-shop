@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <img src="{{ asset('storage/products/'.$product->image) }}" alt="Product Image" class="img-fluid" style="height: 300px; width:300px;">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                
                <p class="lead">Price: ${{ $product->price }}</p>
                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="input-group mb-3">
                        <input type="number" name="qty" class="form-control" value="1" min="1">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Add to Cart</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

