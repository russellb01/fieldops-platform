<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class MailTestController extends Controller
{
    public function show(): View
    {
        return view('office.mail.test', [
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'fromAddress' => config('mail.from.address'),
            'fromName' => config('mail.from.name'),
        ]);
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'to' => ['required', 'email'],
        ]);

        try {
            Mail::raw(
                "This is a FieldOps Office test email from Loudon Mechanical Services.\n\nIf you received this, email sending is working.",
                function ($message) use ($data) {
                    $message->to($data['to'])
                        ->subject('FieldOps Office Test Email');
                }
            );
        } catch (Throwable $e) {
            return back()->withInput()->withErrors([
                'email' => 'Mail test failed: ' . $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Test email sent to ' . $data['to'] . '.');
    }
}
