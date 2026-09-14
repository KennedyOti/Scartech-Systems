<?php

use App\Models\Product;
use App\Models\Service;
use Database\Seeders\DatabaseSeeder;

it('lists public urls and excludes inactive products', function () {
    $this->seed(DatabaseSeeder::class);

    $inactive = Product::where('is_active', false)->firstOrFail();
    $active = Product::active()->firstOrFail();

    $response = $this->get(route('sitemap'))
        ->assertOk()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
        ->assertSee('<loc>'.route('home').'</loc>', false)
        ->assertSee('<loc>'.route('products.show', $active).'</loc>', false)
        ->assertDontSee(route('products.show', $inactive), false);

    foreach (Service::active()->get() as $service) {
        $response->assertSee('<loc>'.route('services.show', $service).'</loc>', false);
    }
});
