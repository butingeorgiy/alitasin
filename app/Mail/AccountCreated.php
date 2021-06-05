<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreated extends Mailable
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
     * Determine if registered user is partner
     *
     * @var bool
     */
    public bool $isPartner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $password, string $firstName, bool $isPartner = false)
    {
        $this->firstName = $firstName;
        $this->password = $password;
        $this->isPartner = $isPartner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AccountCreated
    {

        return $this->subject('You was registered successfully!')
            ->view($this->isPartner ? 'emails.partner-account-created' : 'emails.user-account-created');
    }
}
