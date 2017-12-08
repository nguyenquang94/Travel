<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Order;

class OrderInformation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = Order::findOrFail($this->order_id);
        if ($order->status_id == 1)
        {
            $order->update_status(2, "Auto update after send mail");
        }
        return $this->view('mail.order.info')->with(["order" => Order::findOrFail($this->order_id)]);
    }
}
