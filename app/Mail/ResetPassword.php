<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    public $role;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $email, $role)
    {
        $this->token = $token;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')
                    ->view('emails.reset-password')
                    ->with([
                        'token' => $this->token,
                        'email' => $this->email,
                        'role' => $this->role,
                        ])
                    ->to(request()->email);
    }
}
