<?php

namespace App\Jobs\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class OrderCompletedMail extends Mailable
{
    use Queueable;

    /**
     * @var int
     */
    public $tries = 5;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    public $emailSubject = 'Order is completed';

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $email
     */
    public function __construct(Order $order, string $email)
    {
        $this->order = $order;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->email)
            ->subject($this->emailSubject)
            ->view('emails.orders.completed')
            ->with('order', $this->order)
            ;
    }
}