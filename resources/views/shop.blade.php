@extends('layouts.app')

@section('content')



<div class="row row-cols-1 row-cols-md-4 mt-2 g-4"  >
    @foreach ($products as $product)
        <div class="col">
            <div class="card" >
                <img src="{{ asset('storage/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->image }}" style="height: 300px; width:220px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Price: {{ $product->price }} $</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Product</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection