<?php

namespace App\Telegram\Notifications;

use App;
use App\Models\Region;
use App\Models\Reservation;
use App\Models\Tour;
use App\Models\User;
use App\Services\Telegram\Notifications\MessageNotification;
use Illuminate\Support\Carbon;

class TourReservationNotification extends MessageNotification
{
    protected Tour $tour;
    protected Reservation $reservation;
    protected User $user;

    protected array $allowedPrivileges = ['main_admin', 'reservation_manager'];


    public function __construct(Tour $tour, Reservation $reservation, User $user)
    {
        $this->tour = $tour;
        $this->reservation = $reservation;
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function generateText(): string
    {
        $message = "<b>Новое бронирование №{$this->reservation->id}</b> \n\n\r";

        $message .= "ФИО: {$this->user->full_name} \n\r";
        $message .= "Телефон: {$this->user->phone} \n\r";
        $message .= "E-mail: {$this->user->email} \n\r";
        $message .= "Способ связи: " . ($this->reservation->communication_type ?: 'Не указано') . "\n\r";
        $message .= "Отель: " . ($this->reservation->hotel_name ?: 'Не указано') . "\n\r";
        $message .= "Номер в отеле: " . ($this->reservation->hotel_room_number ?: 'Не указано') . "\n\r";

        /** @var Region|null $region */
        $region = $this->reservation->region()->first();

        if ($region) {
            $region = $region->name;
        } else {
            $region = __('short-phrases.not-specified');
        }

        $message .= "Регион: {$region}\n\n\r";
        $message .= "------------\n\n\r";

        $message .= "Экскурсия: {$this->tour->title[App::getLocale()]} \n\r";

        $tourDate = $this->reservation->date;

        if ($tourDate) {
            $tourDate = Carbon::parse($tourDate)->format('d.m.Y');
        } else {
            $tourDate = 'Не указано';
        }

        $message .= "Дата экскурсии: {$tourDate} \n\n\r";
        $message .= "------------\n\n\r";

        $message .= "<b>Билеты:</b> \n\n\n\r";

        $tickets = $this->reservation->tickets()->withPivot(['amount', 'percent_from_init_cost'])->get();
        foreach ($tickets as $index => $ticket) {
            $message .= ($index + 1) . ". {$ticket->name} x {$ticket->getOriginal('pivot_amount')} шт – $"
                . ($this->reservation->tour_init_price * $ticket->getOriginal('pivot_percent_from_init_cost') / 100) . "\n\r";
        }

        if ($this->reservation->isUsedPromoCode()) {
            $totalCost = $this->reservation->total_cost_without_sale * (100 - $this->reservation->promo_code_init_sale_percent) / 100;
            $discount = $this->reservation->total_cost_without_sale * $this->reservation->promo_code_init_sale_percent / 100;

            $promoCode = $this->reservation->promoCode->code;
        } else {
            $totalCost = $this->reservation->total_cost_without_sale;
        }

        $message .= "\n\rСкидка: $" . ($discount ?? 0) . "\n\r";
        $message .= "Промо код: " . ($promoCode ?? 'Не указан') . "\n\r";
        $message .= "Итого: $$totalCost \n\n\n\n\n\n";

        return $message;
    }
}