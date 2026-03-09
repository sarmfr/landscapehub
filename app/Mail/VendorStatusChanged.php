<?php

namespace App\Mail;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $status;
    public $reason;

    public function __construct(Vendor $vendor, $status, $reason = null)
    {
        $this->vendor = $vendor;
        $this->status = $status;
        $this->reason = $reason;
    }

    public function build()
    {
        $subject = "Update on your LandscapeHub Vendor Account";

        return $this->subject($subject)
            ->view('emails.vendor_status');
    }
}
