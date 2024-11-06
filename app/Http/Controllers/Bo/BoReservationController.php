<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Mail\ReservationCancellation;
use App\Models\Company;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BoReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $selectedCompany = Company::find(session()->get('selected_company'));

        $reservations = $selectedCompany->reservations()->orderBy('start_at', 'asc')->get();

        return view('bo.reservations.all')
            ->with('selectedCompany', $selectedCompany)
            ->with('reservations', $reservations);
    }

    public function edit($id)
    {
        $selectedCompany = Company::find(session()->get('selected_company'));
        $reservation = Reservation::find($id);

        return view('bo.reservations.edit')
            ->with('selectedCompany', $selectedCompany)
            ->with('reservation', $reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        $now = Carbon::now();
        $now = $now->toDateTimeString();

        $reservation->update([
            'cancelled_at' => $now,
            'cancelled_by_company' => true,
            'reason_for_cancellation' => $request->reason_for_cancellation
        ]);

        Mail::to(User::findOrFail($reservation->user_id))->send(new ReservationCancellation($reservation));

        return redirect()->route('bo.reservations.all');
    }

    public function filterStartDate(Request $request)
    {
        if ($request->dateFrom === NULL && $request->dateTo === NULL) {
            $dateFrom = Carbon::createFromFormat('Y-m-d', Carbon::now()->toDateString())->startOfDay();
            $dateTo = Carbon::createFromFormat('Y-m-d', Carbon::now()->toDateString())->endOfDay();
        } else {
            $dateFrom = $request->dateFrom ? Carbon::createFromFormat('Y-m-d', $request->dateFrom)->startOfDay() : Carbon::createFromFormat('Y-m-d', "2000-01-01");
            $dateTo = $request->dateTo ? Carbon::createFromFormat('Y-m-d', $request->dateTo)->endOfDay() : Carbon::createFromFormat('Y-m-d', "2200-01-01");
        }

        $reservations = Reservation::whereBetween('start_at', [$dateFrom, $dateTo])->orderBy('start_at', 'asc')->get();

        $selectedCompany = Company::find(session()->get('selected_company'));

        return view('bo.reservations.all')
            ->with('selectedCompany', $selectedCompany)
            ->with('reservations', $reservations);
    }
}
