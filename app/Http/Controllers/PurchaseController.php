<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Mail\PurchaseConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function store(Product $product)
    {
        // Create a purchase record
        $purchase = Purchase::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'transaction_id' => 'TRX-' . Str::random(10),
            'confirmation_token' => Str::random(32),
            'is_confirmed' => false,
        ]);

        // Send confirmation email
        Mail::to(auth()->user()->email)->send(new PurchaseConfirmation($purchase));

        return redirect()->route('dashboard')
            ->with('success', 'Please check your email to confirm your purchase.');
    }

    public function confirm(string $token)
    {
        $purchase = Purchase::where('confirmation_token', $token)->firstOrFail();
        
        // Mark purchase as confirmed
        $purchase->update(['is_confirmed' => true]);

        return redirect()->route('dashboard')
            ->with('success', 'Your purchase has been confirmed! You can now download the product.');
    }
}