<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $selectedCompany = Company::find(session()->get('selected_company'));

        $services = $selectedCompany->services;

        return view('bo.services.all')
            ->with('selectedCompany', $selectedCompany)
            ->with('services', $services);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $selectedCompany = Company::find(session()->get('selected_company'));
        return view('bo.services.create')->with('selectedCompany', $selectedCompany);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'length' => ['required', 'integer', 'min:1'],
        ]);

        $selectedCompany = Company::find(session()->get('selected_company'));
        $selectedCompany->services()->create($request->all()); 

        session()->flash('success', 'Úspešné vytvorenie služby');

        return redirect()->route('bo.services.create');
    }

    public function edit($id)
    {
        $selectedCompany = Company::find(session()->get('selected_company'));
        $service = Service::find($id);

        return view('bo.services.edit')
            ->with('selectedCompany', $selectedCompany)
            ->with('service', $service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'length' => ['required', 'integer', 'min:1'],
        ]);
        $service->update($request->all());

        session()->flash('success', 'Úspešné upravenie');

        return redirect()->route('bo.services.edit', $service->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Service::find($id)->forceDelete();
        return redirect()->route('bo.services.all');
    }
}
