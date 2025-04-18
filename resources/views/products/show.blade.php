@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $product->name }}</h1>
            <div class="my-4">
                <p>{{ $product->description }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center my-4">
                <span class="h3">${{ number_format($product->price, 2) }}</span>
                <div>
                    @auth
                        @if(auth()->user()->purchases()->where('product_id', $product->id)->where('is_confirmed', true)->exists())
                            <a href="{{ route('products.download', $product) }}" class="btn btn-success">Download</a>
                        @else
                            <form action="{{ route('purchases.store', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Buy Now</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login to Purchase</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection