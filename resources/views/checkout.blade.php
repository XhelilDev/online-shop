@extends('layouts.app')

@section('content')
    <h2>Checkout</h2>

    <form method="POST" action="{{ route('order.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Emri</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Shtoni fushat e tjera për të dhënat e porosisë -->
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
