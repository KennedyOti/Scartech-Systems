<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequestRequest;
use App\Mail\QuoteRequestReceived;
use App\Models\QuoteRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class QuoteRequestController extends Controller
{
    public function create(Request $request): View
    {
        $services = Service::active()->ordered()->get(['id', 'name', 'slug']);

        return view('pages.quote', [
            'services' => $services,
            'selectedServiceId' => $services->firstWhere('slug', $request->query('service'))?->id,
            'selectedProduct' => str((string) $request->query('product'))->limit(160, '')->toString() ?: null,
        ]);
    }

    public function store(StoreQuoteRequestRequest $request): RedirectResponse
    {
        $quoteRequest = QuoteRequest::create($request->safe()->except('website') + [
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        try {
            Mail::to(config('company.email'))->send(new QuoteRequestReceived($quoteRequest->load('service')));
        } catch (Throwable $exception) {
            Log::error('Quote request email failed to send.', [
                'quote_request_id' => $quoteRequest->id,
                'exception' => $exception->getMessage(),
            ]);
        }

        return redirect()->route('quote.create')
            ->with('status', 'Thanks, we have your request. An engineer will contact you within one working day to discuss your site.');
    }
}
