<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $type; // 'customer' or 'vendor'

    public function __construct(Order $order, $type = 'customer')
    {
        $this->order = $order;
        $this->type = $type;
    }

    public function build()
    {
        $subject = $this->type === 'customer'
            ? "Your LandscapeHub Order #" . $this->order->order_number
            : "New Order Received #" . $this->order->order_number;

        return $this->subject($subject)
            ->view('emails.order_notification');
    }
}
