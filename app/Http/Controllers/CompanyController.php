<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        // Fix applied: Using 'industryRelation'
        $companies = Company::with('industryRelation')->paginate(10);
        $industries = Industry::all();

        return view('master.companies', compact('companies', 'industries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_code' => 'required|unique:companies,company_code',
            'name' => 'required|string|max:255',
            'industry_id' => 'required|exists:industries,id',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        Company::create($validated);

        return redirect()->route('master.companies')
            ->with('success', 'Company created successfully.');
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'company_code' => 'required|unique:companies,company_code,' . $id,
            'name' => 'required|string|max:255',
            'industry_id' => 'required|exists:industries,id',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $company->update($validated);

        return redirect()->route('master.companies')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('master.companies')
            ->with('success', 'Company deleted successfully.');
    }
}