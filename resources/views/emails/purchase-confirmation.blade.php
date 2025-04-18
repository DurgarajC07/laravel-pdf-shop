<!DOCTYPE html>
<html>
<head>
    <title>Confirm Your Purchase</title>
</head>
<body>
    <h1>Confirm Your Purchase</h1>
    <p>Thank you for your purchase of {{ $purchase->product->name }}.</p>
    <p>To confirm your purchase and gain access to your product, please click the button below:</p>
    
    <a href="{{ route('purchases.confirm', $purchase->confirmation_token) }}" style="display: inline-block; background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Confirm Purchase
    </a>
    
    <p>If the button doesn't work, copy and paste this URL into your browser:</p>
    <p>{{ route('purchases.confirm', $purchase->confirmation_token) }}</p>
    
    <p>Thank you for shopping with us!</p>
</body>
</html>