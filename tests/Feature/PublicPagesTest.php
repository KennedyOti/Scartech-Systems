<?php

use App\Models\Client;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\Service;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('seeds all ten active services', function () {
    expect(Service::active()->ordered()->count())->toBe(10);
});

it('shows every service on the home page with the hero carousel', function () {
    $response = $this->get(route('home'))->assertOk();

    foreach (Service::active()->get() as $service) {
        $response->assertSee(route('services.show', $service), false);
    }

    $response
        ->assertSee('Telecom and security systems, supplied, installed and maintained.')
        ->assertSee('aria-roledescription="carousel"', false)
        ->assertSee('"@type":"WebSite"', false)
        ->assertSee('hasOfferCatalog', false);

    expect(substr_count($response->getContent(), '<h1'))->toBe(1);
});

it('shows every technology partner logo on the home and about pages', function (string $routeName) {
    $response = $this->get(route($routeName))->assertOk();

    foreach (config('company.partners') as $partner) {
        expect(public_path($partner['logo']))->toBeFile();

        $response
            ->assertSee(asset($partner['logo']), false)
            ->assertSee('alt="'.e($partner['name']).'"', false);
    }
})->with(['home', 'about']);

it('renders the static pages', function (string $routeName, string $heading) {
    $this->get(route($routeName))
        ->assertOk()
        ->assertSee($heading, false)
        ->assertSee('<link rel="canonical"', false);
})->with([
    'about' => ['about', 'About Scartech Systems'],
    'services' => ['services.index', 'Our services'],
    'products' => ['products.index', 'Products we supply'],
    'portfolio' => ['portfolio.index', 'Our work'],
    'contact' => ['contact.index', 'Contact us'],
    'quote' => ['quote.create', 'Request a quote'],
]);

it('renders every service detail page with a unique title and schema', function () {
    $titles = Service::active()->get()->map(function (Service $service) {
        $content = $this->get(route('services.show', $service))
            ->assertOk()
            ->assertSee('"@type":"Service"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->getContent();

        preg_match('/<title>(.*?)<\/title>/', $content, $matches);

        return $matches[1];
    });

    expect($titles->unique())->toHaveCount(10);
});

it('returns 404 for an inactive service', function () {
    $service = Service::factory()->inactive()->create();

    $this->get(route('services.show', $service))->assertNotFound()->assertSee("We couldn't find that page.", false);
});

it('returns 404 for an inactive product and omits offers from product schema', function () {
    $inactive = Product::where('is_active', false)->firstOrFail();
    $this->get(route('products.show', $inactive))->assertNotFound();

    $active = Product::active()->firstOrFail();
    $this->get(route('products.show', $active))
        ->assertOk()
        ->assertSee('"@type":"Product"', false)
        ->assertDontSee('"offers"', false);
});

it('filters products by category and keeps the filter through pagination', function () {
    $category = ProductCategory::factory()->create(['slug' => 'test-category']);
    Product::factory()->active()->count(14)->for($category, 'category')->create();

    $this->get(route('products.index', ['category' => 'test-category']))
        ->assertOk()
        ->assertSee('category=test-category&amp;page=2', false);
});

it('shows the invitation state for a category without active products', function () {
    $this->get(route('products.index', ['category' => 'fire-safety']))
        ->assertOk()
        ->assertSee('We supply equipment in this category on request. Tell us what you need');
});

it('renders a project with no client and no outcome without stray headings', function () {
    $project = Project::factory()->create(['client_name' => null, 'outcome' => null]);

    $this->get(route('portfolio.show', $project))
        ->assertOk()
        ->assertSee('The challenge')
        ->assertDontSee('The outcome')
        ->assertDontSee('<dt class="text-sm text-slate-500">Client</dt>', false);
});

it('filters the portfolio by service', function () {
    $this->get(route('portfolio.index', ['service' => 'access-control-systems']))
        ->assertOk()
        ->assertSee('Biometric and access control installation')
        ->assertDontSee('High-density patching installation');
});

it('shows every seeded client on the portfolio page', function () {
    $response = $this->get(route('portfolio.index'))
        ->assertOk()
        ->assertSee('Organisations we have worked with');

    expect(Client::count())->toBe(20);

    foreach (Client::all() as $client) {
        if ($client->logo) {
            expect(public_path($client->logo))->toBeFile();

            $response
                ->assertSee(asset($client->logo), false)
                ->assertSee('alt="'.e($client->name).'"', false);
        } else {
            $response->assertSee(e($client->name), false);
        }
    }
});

it('renders a name tile for a client without a logo', function () {
    Client::query()->delete();
    Client::factory()->withoutLogo()->create(['name' => 'Acme Logistics']);

    $this->get(route('portfolio.index'))
        ->assertOk()
        ->assertSee('Acme Logistics')
        ->assertDontSee('alt="Acme Logistics"', false);
});

it('pre-selects the service on the quote form from the query string', function () {
    $service = Service::where('slug', 'cctv-installation')->firstOrFail();

    $this->get(route('quote.create', ['service' => 'cctv-installation', 'product' => 'Hikvision camera']))
        ->assertOk()
        ->assertSee('<option value="'.$service->id.'" selected', false)
        ->assertSee('Hikvision camera');
});
