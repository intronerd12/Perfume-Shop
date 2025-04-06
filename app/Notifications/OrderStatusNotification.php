<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $pdf;

    public function __construct($order, $pdf)
    {
        $this->order = $order;
        $this->pdf = $pdf;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Status Update - #' . $this->order->order_number)
            ->view('emails.order-status', ['order' => $this->order])
            ->attachData($this->pdf->output(), 'order-receipt.pdf');
    }
}
