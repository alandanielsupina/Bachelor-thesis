<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BoUserCompanyController extends Controller
{
    public function all()
    {
        $selectedCompany = NULL;
        $allMyCompanies = Auth::user()->companies;

        if (session()->has('selected_company')) {
            $idSelectedCompany = session()->get('selected_company');

            if (Auth::user()->hasRole('super-admin')) {
                $selectedCompany = Company::find($idSelectedCompany);
            } else {
                $selectedCompany = $allMyCompanies->find($idSelectedCompany);
            }
        }

        return view('bo.user_companies.all')
            ->with('selectedCompany', $selectedCompany)
            ->with('allMyCompanies', $allMyCompanies);
    }

    public function selectCompany($id)
    {
        session()->put('selected_company', $id);

        return redirect()->route('bo.user-companies.all');
    }

    public function preparationForNewCompany()
    {
        session()->forget('new_basic_informations');
        session()->forget('new_schedule');
        return redirect()->route('bo.user-companies.create-basic-informations');
    }

    public function createBasicInformations()
    {
        // TODO poslať udaje zo session
        $categories = Category::all();
        return view('bo.user_companies.new_basic_informations')->with('categories', $categories);
    }

    public function storeBasicInformations(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'image' => ['required', 'mimes:png,jpg,jpeg'],
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $slugName = str_slug($request->get('name'), '-');
        $fileName = $slugName . '.' . $extension;
        $pathToFile = 'uploads/companies/';
        $file->move($pathToFile, $fileName);


        $new_basic_informations = $request->except(['image']);
        $new_basic_informations["image"] = $pathToFile . $fileName;
        session()->put('new_basic_informations', $new_basic_informations);

        return redirect()->route('bo.user-companies.create-schedule');
    }

    public function createSchedule()
    {
        // TODO poslať udaje zo session
        return view('bo.user_companies.new_schedules');
    }

    public function storeSchedule(Request $request)
    {
        if (!$request->days) {
            return $this->customError('Nastavte aspoň jeden deň!');
        } else {
            // $requestData = $request->except(['_token', 'days']);

            // TODO: je v pohode takto porovnávať string ako čísla? Lebo predsa vo $value mám niečo ako "30"
            //Nemám to ešte pretypovať ako (int)$value ?
            //Mal by si to sám pretypovať, ale je asi fajn, keď to spravím aj ja nie?
            // foreach ($requestData as $key => $value) {
            //     if ((int)$value < 0) {
            //         return $this->customError('Nejaká hodina alebo minúta je záporná');
            //     }
            // }

            if (!session()->has('new_basic_informations')) {
                return $this->customError('Základné informácie sa nevyplnili. Skúste to ešte raz. Prípadne nás neváhajte kontaktovať :)');
            } else {
                //TODO: vybrať uložený image a skontrolovať aj jeho prípony ako jpg, png, že či to nie je napr. word alebo pdf. Tu kontrolujem iba cestu k súboru
                //TODO: asi bude potrebné priebežné odstraňovať obrázky cez CRON, ktoré sa výsledne nepoužívajú (nie sú uložené v databáze)
                $validator = Validator::make(session()->get('new_basic_informations'), [
                    'name' => ['required', 'string', 'max:255'],
                    'city' => ['required', 'string', 'max:100'],
                    'address' => ['required', 'string', 'max:255'],
                    'description' => ['required'],
                    'image' => ['required'],
                ]);

                if ($validator->stopOnFirstFailure()->fails()) {
                    return $this->customError('Vrátte sa naspäť k vyplneniu základných informácií. Niečo je zle vyplnené!');
                }

                $newBasicInformations = session()->get('new_basic_informations');

                $company = Company::create([
                    'user_id' => auth()->id(),
                    'name' => $newBasicInformations['name'],
                    'city' => $newBasicInformations['city'],
                    'address' => $newBasicInformations['address'],
                    'description' => $newBasicInformations['description'],
                    'image' => $newBasicInformations['image']
                ]);

                $company->categories()->sync($newBasicInformations['categories'] ?: []);

                if (!$this->addSchedulesToDatabase($company, $request)) {
                    return $this->customError('Nastal problém pri pridávaní otváracích hodín do databázy!');
                }

                session()->put('selected_company', $company->id);

                session()->forget('new_basic_informations');
                session()->forget('new_schedule');

                return redirect()->route('bo.user-companies.all');
            }
        }
    }

    private function customError($message)
    {
        session()->flash('error', $message);
        return redirect()->route('bo.user-companies.create-schedule');
    }

    private function addSchedulesToDatabase($company, $request)
    {
        $days = $request->days;
        if (in_array("mon", $days)) {
            $piecesStart = explode(":", $request->get('mon-start'));
            $piecesEnd = explode(":", $request->get('mon-end'));

            $company->schedules()->create([
                'day' => 'mon',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        if (in_array("tue", $days)) {
            $piecesStart = explode(":", $request->get('tue-start'));
            $piecesEnd = explode(":", $request->get('tue-end'));

            $company->schedules()->create([
                'day' => 'tue',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        if (in_array("wed", $days)) {
            $piecesStart = explode(":", $request->get('wed-start'));
            $piecesEnd = explode(":", $request->get('wed-end'));

            $company->schedules()->create([
                'day' => 'wed',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        if (in_array("thu", $days)) {
            $piecesStart = explode(":", $request->get('thu-start'));
            $piecesEnd = explode(":", $request->get('thu-end'));

            $company->schedules()->create([
                'day' => 'thu',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        if (in_array("fri", $days)) {
            $piecesStart = explode(":", $request->get('fri-start'));
            $piecesEnd = explode(":", $request->get('fri-end'));

            $company->schedules()->create([
                'day' => 'fri',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        if (in_array("sat", $days)) {
            $piecesStart = explode(":", $request->get('sat-start'));
            $piecesEnd = explode(":", $request->get('sat-end'));

            $company->schedules()->create([
                'day' => 'sat',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        if (in_array("sun", $days)) {
            $piecesStart = explode(":", $request->get('sun-start'));
            $piecesEnd = explode(":", $request->get('sun-end'));

            $company->schedules()->create([
                'day' => 'sun',
                'start_hours' => $piecesStart[0],
                'start_minutes' => $piecesStart[1],
                'end_hours' => $piecesEnd[0],
                'end_minutes' => $piecesEnd[1],
            ]);
        }

        return true;
    }
}
