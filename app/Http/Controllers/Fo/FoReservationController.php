<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancellation;

class FoReservationController extends Controller
{
    public function showCalendar()
    {
        $reservationsArray = Auth::user()->reservations()
            ->whereNull('cancelled_at')
            ->select('start_at')
            ->get()
            ->pluck('start_at')
            ->map(function ($dateTime) {
                return Carbon::parse($dateTime)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        $today = Carbon::today();
        $todayReservations = Auth::user()->reservations()->whereNull('cancelled_at')->whereDate('start_at', $today->toDateString())->orderBy('start_at', 'asc')->get();
        $todayString = $today->toDateString();

        return view('fo.reservations.calendar')
            ->with('reservationsArray', $reservationsArray)
            ->with('todayReservations', $todayReservations)
            ->with('day', $todayString);

    }

    public function showDay($day)
    {
        $reservations = Auth::user()->reservations()->whereNull('cancelled_at')->whereDate('start_at', $day)->orderBy('start_at', 'asc')->get();

        return view('fo.reservations.day')
            ->with('day', $day)
            ->with('reservations', $reservations);
    }

    public function edit($day, $id)
    {
        $reservation = Reservation::find($id);
        return view('fo.reservations.single')
            ->with('reservation', $reservation)
            ->with('day', $day);
    }

    public function update(Request $request, $day, $id)
    {
        $reservation = Reservation::find($id);

        $now = Carbon::now();
        $now = $now->toDateTimeString();

        $reservation->update([
            'cancelled_at' => $now,
            'cancelled_by_company' => false,
            'reason_for_cancellation' => $request->reason_for_cancellation
        ]);

        Mail::to($reservation->service->company->user)->send(new ReservationCancellation($reservation));

        return redirect()->route('fo.reservations.show-day', $day);
    }
}
