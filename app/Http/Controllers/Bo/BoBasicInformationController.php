<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BoBasicInformationController extends Controller
{
    public function show()
    {
        $selectedCompany = NULL;
        $categories = Category::all();

        if (session()->has('selected_company')) {
            $selectedCompany = Company::find(session()->get('selected_company'));
        }

        $selectedCompany->categories;

        return view('bo.basic_informations.show')
            ->with('selectedCompany', $selectedCompany)
            ->with('categories', $categories);
    }

    public function edit($id)
    {
        $company = Company::find($id);
        $this->checkCompanyIsSelectedCompany($company);

        $company->categories;

        $categories = Category::all();

        return view('bo.basic_informations.edit')
            ->with('selectedCompany', $company)
            ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $this->checkCompanyIsSelectedCompany($company);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg'],
        ]);

        if ($request->hasFile('image')) {
            if (File::exists($company->image)) {
                File::delete($company->image);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $slugName = str_slug($request->get('name'), '-');
            $fileName = $slugName . '.' . $extension;
            $pathToFile = 'uploads/companies/';
            $file->move($pathToFile, $fileName);

            $company->update([
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'description' => $request->description,
                'image' => $pathToFile . $fileName
            ]);
        } else {
            $company->update([
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'description' => $request->description
            ]);
        }

        $company->categories()->sync($request['categories'] ?: []);

        session()->flash('success', 'Úspešné upravenie.');

        return redirect()->route('bo.basic-informations.edit', $company->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $this->checkCompanyIsSelectedCompany($company);

        $company->delete();

        session()->forget('selected_company');

        return redirect()->route('bo.user-companies.all');
    }

    private function checkCompanyIsSelectedCompany($company)
    {
        $selectedCompany = NULL;

        if (session()->has('selected_company')) {
            $selectedCompany = Company::find(session()->get('selected_company'));
        }

        if (!$selectedCompany->is($company)) {
            session()->flash('error', "Tento podnik nie je vybraný podnik v pamäti!");
            return redirect()->route('bo.user-companies.all');
        }

        return NULL;
    }
}
