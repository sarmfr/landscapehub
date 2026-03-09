<?php

namespace App\Mail;

use App\Models\Quote;
use App\Models\QuoteResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteAcceptedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $response;

    public function __construct(Quote $quote, QuoteResponse $response)
    {
        $this->quote = $quote;
        $this->response = $response;
    }

    public function build()
    {
        return $this->subject("Congratulations! Your Proposal has been Accepted")
            ->view('emails.quote_accepted');
    }
}
