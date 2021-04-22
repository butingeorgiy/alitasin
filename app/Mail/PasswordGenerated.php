<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordGenerated extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * User's first name
     *
     * @var string
     */
    public $firstName;

    /**
     * User's password
     *
     * @var string
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $password, string $firstName)
    {
        $this->firstName = $firstName;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): PasswordGenerated
    {
        return $this->view('emails.password');
    }
}
