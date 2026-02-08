<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawalApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawal;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($withdrawal, $user)
    {
        $this->withdrawal = $withdrawal;
        $this->user = $user;
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject('🎉 Withdrawal Approved - Castle Royal Agro')
                    ->view('emails.withdrawals.approved');
    }
}
