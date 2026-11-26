<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Show the list of all companies
    public function index()
    {
        return view('companies.index', ['companies' => Company::all()]);
    }

    // Show the empty "add company" form
    public function create()
    {
        return view('companies.create');
    }

    // Validate the form and save a new company
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'city'  => 'required|string|max:100',
            'field' => 'required|string|max:100',
            'seats' => 'required|integer|min:1',
        ]);

        Company::create($data);

        return redirect('/companies')->with('success', 'messages.company_added');
    }

    // Show the edit form filled with the company's data
    public function edit(Company $company)
    {
        return view('companies.edit', ['company' => $company]);
    }

    // Validate the form and update the company
    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'city'  => 'required|string|max:100',
            'field' => 'required|string|max:100',
            'seats' => 'required|integer|min:1',
        ]);

        $company->update($data);

        return redirect('/companies')->with('success', 'messages.company_updated');
    }

    // Delete a company, unless it still has placements (foreign key protection)
    public function destroy(Company $company)
    {
        if ($company->placements()->exists()) {
            return redirect('/companies')->with('error', 'messages.company_has_placements');
        }

        $company->delete();

        return redirect('/companies')->with('success', 'messages.company_deleted');
    }
}
