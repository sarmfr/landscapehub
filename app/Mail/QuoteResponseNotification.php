<?php

namespace App\Mail;

use App\Models\QuoteResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $response;

    public function __construct(QuoteResponse $response)
    {
        $this->response = $response;
    }

    public function build()
    {
        return $this->subject("New Proposal for your Landscaping Request")
            ->view('emails.quote_responded');
    }
}
