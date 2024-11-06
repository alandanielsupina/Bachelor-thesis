<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;

class FoSearchingController extends Controller
{
    public function selectCity()
    {
        $companies = Company::where('active', true)->orderBy('city')->get();
        $uniqueCities = [];

        foreach ($companies as $company) {
            if (!in_array($company['city'], $uniqueCities)) {
                $uniqueCities[] = $company['city'];
            }
        }

        return view('fo.searching.select_city')->with('uniqueCities', $uniqueCities);
    }

    public function all($selectedCity)
    {
        $companies = Company::where('active', true)->where('city', $selectedCity)->with('categories')->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('fo.searching.companies')
            ->with('companies', $companies)
            ->with('categories', $categories)
            ->with('selectedCity', $selectedCity);
    }

    public function filterCategory(Request $request, $selectedCity)
    {
        $categories = Category::orderBy('name')->get();
        if ($request->category === "all") {
            $companies = Company::where('active', true)->where('city', $selectedCity)->with('categories')->orderBy('name')->get();
        } else {
            $companies = Category::where('name', $request->category)->first()->companies()->where('active', true)->where('city', $selectedCity)->with('categories')->orderBy('name')->get();
        }

        return view('fo.searching.companies')
            ->with('companies', $companies)
            ->with('categories', $categories)
            ->with('selectedCity', $selectedCity);
    }

    public function searchCompanyName(Request $request, $selectedCity)
    {
        $categories = Category::orderBy('name')->get();
        $search = $request->input('search');
        $companies = Company::where('active', true)->where('city', $selectedCity)->where('name', 'like', "%$search%")->with('categories')->orderBy('name')->get();

        return view('fo.searching.companies')
            ->with('companies', $companies)
            ->with('categories', $categories)
            ->with('selectedCity', $selectedCity);
    }

    public function showCompany($selectedCity, $idCompany)
    {
        $company = Company::find($idCompany);

        return view('fo.searching.company')
            ->with('company', $company)
            ->with('selectedCity', $selectedCity);
    }

    public function showCompanyServices($selectedCity, $idCompany)
    {
        $company = Company::find($idCompany);

        $services = $company->services;

        return view('fo.searching.company_services')
            ->with('company', $company)
            ->with('selectedCity', $selectedCity)
            ->with('services', $services);
    }

    public function showDateTime($selectedCity, $idCompany, $idService)
    {
        $company = Company::find($idCompany);
        $service = Service::find($idService);


        return view('fo.searching.company_date_time')
            ->with('company', $company)
            ->with('selectedCity', $selectedCity)
            ->with('service', $service);
    }

    public function store(Request $request, $selectedCity, $idCompany, $idService)
    {
        $this->validate($request, [
            'date' => ['required', 'date_format:"Y-m-d"'],
            'time' => ['required', 'date_format:"H:i"']
        ]);

        $company = Company::find($idCompany);
        $service = Service::find($idService);

        $day = Carbon::createFromFormat('Y-m-d', $request->date);
        $dayShortName = strtolower($day->shortLocaleDayOfWeek);
        $schedule = $company->schedules()->where('day', $dayShortName)->first();
        if ($schedule === NULL) {
            session()->flash('error', 'Dátum a čas sú mimo otváracích hodín!');
            return redirect()->route('fo.searching.show-date-time', [$selectedCity, $company->id, $service->id]);
        }
        $start = Carbon::createFromFormat('H:i', $schedule->getStartHoursMinutes());
        $end = Carbon::createFromFormat('H:i', $schedule->getEndHoursMinutes());
        $time = Carbon::createFromFormat('H:i', $request->time);

        $start_at = Carbon::createFromFormat('Y-m-d H:i:s', $day->toDateString() . " " . $time->toTimeString());
        $end_at = $start_at->copy()->addMinutes($service->length);

        if ($time->betweenIncluded($start, $end)) {
            $reservation = Reservation::create([
                'service_id' => $service->id,
                'user_id' => auth()->id(),
                'start_at' => $start_at->toDateTimeString(),
                'end_at' => $end_at->toDateTimeString()
            ]);

            session()->flash('company', $company->id);
            session()->flash('service', $service->id);
            session()->flash('reservation', $reservation->id);

            return redirect()->route('fo.searching.show-created-reservation');
        } else {
            session()->flash('error', 'Dátum a čas sú mimo otváracích hodín!');
            return redirect()->route('fo.searching.show-date-time', [$selectedCity, $company->id, $service->id]);
        }
    }

    public function showCreatedReservation()
    {
        $company = Company::find(session()->get('company'));
        $service = Service::find(session()->get('service'));
        $reservation = Reservation::find(session()->get('reservation'));

        return view('fo.searching.created_reservation')
            ->with('company', $company)
            ->with('service', $service)
            ->with('reservation', $reservation);
    }
}
