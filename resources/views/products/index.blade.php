@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Our Products</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection