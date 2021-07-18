<?php

namespace App\Mail;

use App\Models\Reservation;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TourReserved extends Mailable
{
    use Queueable, SerializesModels;

    public Tour $tour;
    public Reservation $reservation;
    public User $user;
    public bool $isAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tour $tour, Reservation $reservation, User $user, bool $isAdmin = false)
    {
        $this->tour = $tour;
        $this->reservation = $reservation;
        $this->user = $user;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Mailable
    {
        $buildResponse = $this->view('emails.tour-reserved')
            ->subject($this->isAdmin ? 'Новое бронирование на Ali Tour!' : __('emails.excursion-reservation-on-ali-tour'));

        if (!$this->isAdmin && Storage::exists('tickets/' . $this->reservation->id . '.pdf')) {
            $buildResponse->attach(__DIR__ . '/../../storage/app/tickets/' . $this->reservation->id . '.pdf', [
                'as' => 'ticket.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $buildResponse;
    }
}
