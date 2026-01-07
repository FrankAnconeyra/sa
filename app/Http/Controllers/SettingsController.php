<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Show the company settings form.
     */
    public function company()
    {
        $company = Auth::user()->company;
        return view('settings.company', compact('company'));
    }

    /**
     * Update the company settings.
     */
    public function updateCompany(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'ruc' => 'required|string|size:11|unique:companies,ruc,' . Auth::user()->company_id,
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $company = Auth::user()->company;
        $company->update([
            'business_name' => $request->business_name,
            'trade_name' => $request->trade_name,
            'ruc' => $request->ruc,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('settings.company')->with('success', 'Configuración actualizada exitosamente.');
    }
}