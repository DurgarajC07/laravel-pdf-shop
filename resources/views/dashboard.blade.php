@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Dashboard</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card mt-4">
        <div class="card-header">Your Purchases</div>
        <div class="card-body">
            @if($purchases->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->product->name }}</td>
                                    <td>{{ $purchase->transaction_id }}</td>
                                    <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($purchase->is_confirmed)
                                            <span class="badge bg-success">Confirmed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($purchase->is_confirmed)
                                            <a href="{{ route('products.download', $purchase->product) }}" class="btn btn-sm btn-success">Download</a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Awaiting Confirmation</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>You haven't made any purchases yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
            @endif
        </div>
    </div>
</div>
@endsection
