<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Mail\ReservationCancellation;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BoReservationManagmentController extends Controller
{
    public function all()
    {
        $today = Carbon::today();
        $reservations = Reservation::whereDate('start_at', '=', $today->toDateString())->get();

        return view('bo.admin.reservation_managment')
            ->with('reservations', $reservations);
    }

    public function sendNotifications()
    {
        $today = Carbon::today();
        $reservations = Reservation::whereDate('start_at', '=', $today->toDateString())->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user)->send(new ReservationCancellation($reservation));
        }

        return redirect()->route('bo.reservation-management.all');
    }
}
