<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCodeNumber extends Mailable
{
    use Queueable, SerializesModels;

    public $orderNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(['address' => 'paperflavors@gmail.com', 'name' => 'paperflavors'])
                    ->subject('Regarding Your Order Code ')
                    ->view('mails.order-number', compact('orderNumber'));
    }
}