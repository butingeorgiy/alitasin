<?php

namespace App\Mail;

use App\Models\TransferRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferRequestCreated extends Mailable
{
    use Queueable;
    use SerializesModels;


    public TransferRequest $transferRequest;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TransferRequest $transferRequest)
    {
        $this->transferRequest = $transferRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): TransferRequestCreated
    {
        return $this->view('emails.transfer-request-created')
            ->subject('Заявка на трансфер с Ali Tour!');
    }

    /**
     * Return tested instance.
     *
     * @return TransferRequestCreated
     */
    public static function getTestingInstance(): TransferRequestCreated
    {
        $transferRequest = TransferRequest::limit(1)->first();

        return new TransferRequestCreated($transferRequest);
    }
}
