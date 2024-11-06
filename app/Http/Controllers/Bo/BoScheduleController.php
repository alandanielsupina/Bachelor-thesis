<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BoScheduleController extends Controller
{
    public function show()
    {
        $selectedCompany = Company::find(session()->get('selected_company'));

        $schedules = $selectedCompany->schedules;

        return view('bo.schedules.show')
            ->with('selectedCompany', $selectedCompany)
            ->with('schedules', $schedules);
    }

    public function edit()
    {
        $selectedCompany = Company::find(session()->get('selected_company'));
        $schedules = $selectedCompany->schedules;

        return view('bo.schedules.edit')
            ->with('selectedCompany', $selectedCompany)
            ->with('schedules', $schedules);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!$request->days) {
            return $this->customError('Nastavte aspoň jeden deň!');
        } else {
            $selectedCompany = Company::find(session()->get('selected_company'));

            if (!$this->addSchedulesToDatabase($selectedCompany, $request)) {
                return $this->customError('Nastal problém pri pridávaní otváracích hodín do databázy!');
            }
        }

        session()->flash('success', 'Úspešné upravenie.');

        return redirect()->route('bo.schedules.edit', $selectedCompany->id);
    }

    private function customError($message)
    {
        session()->flash('error', $message);
        return redirect()->route('bo.schedules.edit');
    }

    private function addSchedulesToDatabase($company, $request)
    {
        $days = $request->days;
        $allDays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        foreach ($allDays as $day) {
            if (in_array($day, $days)) {
                $piecesStart = explode(":", $request->get($day . '-start'));
                $piecesEnd = explode(":", $request->get($day . '-end'));

                $company->schedules()->updateOrCreate(
                    ['day' => $day], // podmienka pre nájdenie záznamu
                    [
                        'start_hours' => $piecesStart[0],
                        'start_minutes' => $piecesStart[1],
                        'end_hours' => $piecesEnd[0],
                        'end_minutes' => $piecesEnd[1],
                    ]
                );
            } else {
                // Ak deň nie je zahrnutý v $days, vymažeme záznam z databázy
                $company->schedules()->where('day', $day)->forceDelete();
            }
        }

        return true;
    }
}
