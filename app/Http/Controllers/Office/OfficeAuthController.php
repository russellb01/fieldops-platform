<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfficeAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('office.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'pin' => ['required', 'string'],
        ]);

        $pin = (string) config('fieldops.office_pin');

        if ($pin !== '' && hash_equals($pin, (string) $request->input('pin'))) {
            $request->session()->put('fieldops_office_authenticated', true);

            return redirect()->route('office.dashboard')->with('success', 'Welcome to FieldOps Office.');
        }

        return back()->withErrors(['pin' => 'That office PIN was not correct.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('fieldops_office_authenticated');

        return redirect()->route('office.login')->with('success', 'Signed out.');
    }
}
