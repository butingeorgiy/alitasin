<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use phpDocumentor\Reflection\Types\This;

class PasswordGenerated extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * User's first name
     *
     * @var string
     */
    public string $firstName;

    /**
     * User's password
     *
     * @var string
     */
    public string $password;

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
        return $this->subject('You was registered successfully!')
            ->view('emails.password');
    }
}
