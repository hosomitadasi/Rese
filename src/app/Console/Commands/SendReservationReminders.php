<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservation;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reservation reminders';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();
        $reservations = Reservation::whereDate('reservation_date', $today->copy()->addDay())->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationReminder($reservation));
        }
    }
}
