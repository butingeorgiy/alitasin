<?php

namespace App\Mail;

use App\Models\Reservation;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TourReserved extends Mailable
{
    use Queueable, SerializesModels;

    public Tour $tour;
    public Reservation $reservation;
    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tour $tour, Reservation $reservation, User $user)
    {
        $this->tour = $tour;
        $this->reservation = $reservation;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Mailable
    {
        return $this->view('emails.reservation')
            ->subject(__('emails.excursion-reservation-on-ali-tour'));
    }
}
