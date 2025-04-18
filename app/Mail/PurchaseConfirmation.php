<?php

namespace App\Mail;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Your Purchase',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase-confirmation',
        );
    }
}