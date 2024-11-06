<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class BoAllCompanyController extends Controller
{
    public function all()
    {
        $companies = Company::withTrashed()->get();

        return view('bo.admin.all_companies')->with('companies', $companies);
    }

    public function selectCompany($id)
    {
        session()->put('selected_company', $id);

        return redirect()->route('bo.all-companies.all');
    }

    public function restore($id)
    {
        Company::withTrashed()->find($id)->restore();
        return redirect()->route('bo.all-companies.all');
    }
}
