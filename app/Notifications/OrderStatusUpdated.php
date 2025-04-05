<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;
use PDF;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $pdf = PDF::loadView('emails.order-receipt', ['order' => $this->order]);

        return (new MailMessage)
            ->subject('Order Status Updated - #' . $this->order->order_number)
            ->line('Your order status has been updated to: ' . $this->order->status)
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Total Amount: $' . $this->order->total_amount)
            ->attachData($pdf->output(), 'receipt.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
