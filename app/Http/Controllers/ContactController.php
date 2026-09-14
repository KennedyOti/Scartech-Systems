<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact', [
            'services' => Service::active()->ordered()->get(['id', 'name', 'slug']),
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $message = ContactMessage::create($request->safe()->except('website') + [
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        try {
            Mail::to(config('company.email'))->send(new ContactMessageReceived($message));
        } catch (Throwable $exception) {
            Log::error('Contact message email failed to send.', [
                'contact_message_id' => $message->id,
                'exception' => $exception->getMessage(),
            ]);
        }

        return redirect()->route('contact.index')
            ->with('status', 'Thanks, your message has reached our team. We reply within one working day.');
    }
}
