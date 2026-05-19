<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class CompanyController extends Controller
{
    public function edit()
    {
        $company = auth()->user()->company;
        return view('institute.company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        auth()->user()->company->update($request->all());

        return back()->with('success', 'Company profile updated!');
    }
}
