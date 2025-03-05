<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($token)
    {
        $this->resetUrl = route('password.reset', ['token' => $token]);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reset Your Password - ' . config('app.name'))
                    ->markdown('emails.password_reset')
                    ->with([
                        'resetUrl' => $this->resetUrl,
                    ]);
    }
}

