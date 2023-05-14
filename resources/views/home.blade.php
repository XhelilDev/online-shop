@extends('layouts.app')

@section('content')

<h2>Latest Products</h2>
<!-- 
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
  <div class="carousel-inner">
  @foreach ($latestProducts as $product)
    <div class="carousel-item active">
      <img src="{{ asset('storage/products/'.$product->image) }}" class="d-block" alt="...">
    </div>
    @endforeach
  
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div> -->



<div class="row row-cols-1 row-cols-md-4 mt-2 g-4"  >
    @foreach ($latestProducts as $product)
        <div class="col">
            <div class="card"  >
                <img src="{{ asset('storage/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->image }}"  style="height: 300px; width:220px;">
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
<div class="d-flex justify-content-center mt-4">
    <a href="{{ route('shop') }}" class="btn btn-danger">More Products</a>
</div>
@endsection
