<?php

use App\Mail\ContactMessageReceived;
use App\Mail\QuoteRequestReceived;
use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;

function contactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Jane Wanjiru',
        'email' => 'jane@example.com',
        'phone' => '+254 700 000 000',
        'company' => 'Example Ltd',
        'subject' => 'General enquiry',
        'message' => 'We need CCTV cameras for a two-storey office in Westlands.',
        'website' => '',
    ], $overrides);
}

it('stores a contact message and emails the team', function () {
    Mail::fake();

    $this->post(route('contact.store'), contactPayload())
        ->assertRedirect(route('contact.index'))
        ->assertSessionHas('status');

    $message = ContactMessage::sole();
    expect($message->email)->toBe('jane@example.com')
        ->and($message->source)->toBe('contact');

    Mail::assertSent(ContactMessageReceived::class, fn ($mail) => $mail->hasTo(config('company.email')) && $mail->hasReplyTo('jane@example.com'));
});

it('still succeeds when the contact email fails to send', function () {
    Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP unavailable'));

    $this->post(route('contact.store'), contactPayload())
        ->assertRedirect(route('contact.index'))
        ->assertSessionHas('status');

    expect(ContactMessage::count())->toBe(1);
});

it('validates the contact form with plain-language messages', function () {
    $this->post(route('contact.store'), contactPayload(['phone' => '', 'message' => 'Too short']))
        ->assertSessionHasErrors([
            'phone' => 'Enter a phone number we can reach you on.',
            'message',
        ]);

    expect(ContactMessage::count())->toBe(0);
});

it('rejects contact submissions that fill the honeypot', function () {
    $this->post(route('contact.store'), contactPayload(['website' => 'http://spam.test']))
        ->assertSessionHasErrors('website');

    expect(ContactMessage::count())->toBe(0);
});

it('stores a quote request and emails the team', function () {
    Mail::fake();
    $service = Service::factory()->create();

    $this->post(route('quote.store'), [
        'name' => 'Otieno Kamau',
        'email' => 'otieno@example.com',
        'phone' => '+254 711 111 111',
        'service_id' => $service->id,
        'product' => 'Hikvision camera',
        'location' => 'Mombasa',
        'site_type' => 'School/campus',
        'timeline' => 'Within a month',
        'needs_site_survey' => '1',
        'details' => 'Three classroom blocks and a gate that need camera coverage.',
        'website' => '',
    ])->assertRedirect(route('quote.create'))->assertSessionHas('status');

    $quote = QuoteRequest::sole();
    expect($quote->service_id)->toBe($service->id)
        ->and($quote->needs_site_survey)->toBeTrue()
        ->and($quote->status)->toBe('new');

    Mail::assertSent(QuoteRequestReceived::class);
});

it('rejects a quote request with an unknown site type', function () {
    $this->post(route('quote.store'), [
        'name' => 'Otieno Kamau',
        'email' => 'otieno@example.com',
        'phone' => '+254 711 111 111',
        'site_type' => 'Spaceship',
        'details' => 'Three classroom blocks and a gate that need camera coverage.',
    ])->assertSessionHasErrors('site_type');

    expect(QuoteRequest::count())->toBe(0);
});
