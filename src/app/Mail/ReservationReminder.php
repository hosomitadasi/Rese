<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->view('emails.reservation_reminder')
        ->with([
            'date' => $this->reservation->reservation_date,
            'time' => $this->reservation->reservation_time,
            'store' => $this->reservation->store->name,
            'num_people' => $this->reservation->num_people,
            'name' => $this->reservation->user->name,
        ]);
    }
}
