# Scartech Systems Limited — Corporate Website

**Build specification and implementation plan.**
Hand this file to Claude Code in VS Code and work through it phase by phase.

---

## 0. How to use this document

This is the single source of truth for the build. Work top to bottom.

1. Read sections 1–5 fully before writing any code. They define the design language and the routes; everything else depends on them.
2. Build in the phase order given in section 17. Do not jump ahead — the design tokens must exist before components, components before pages.
3. After each phase, run the checks listed at the end of that phase.
4. Section 18 is the acceptance checklist. The site is not done until every box is ticked.
5. Where this document says **CONFIRM WITH CLIENT**, do not invent content. Leave the record inactive or use the placeholder pattern described in section 16.6.

Suggested opening instruction to Claude Code:

> Read `SCARTECH_WEBSITE_BUILD_PLAN.md` in full. Then execute Phase 1 only, and stop so I can review before you continue.

---

## 1. Project brief

**Client:** Scartech Systems Limited — IT, telecommunications and electronic security provider. HQ Nairobi, Kenya, with offices in Kampala (Uganda) and Kigali (Rwanda). Expanding to Tanzania and Burundi.

**What they do:** supply, installation and maintenance of telecom and security systems. They are advisors, installers and maintainers — not a software SaaS company, not a reseller-only shop. Everything they sell, they also install and service.

**Primary business goal of the site:** get qualified enquiries. A facilities manager, IT manager, school bursar, or project contractor lands on the site, sees within five seconds that Scartech does the exact thing they need, and requests a quote or a site survey.

**Audience:** procurement officers, IT managers, facility and estate managers, architects and main contractors, school and hospital administrators, bank and SACCO operations staff, hotel GMs. Mostly on mobile, often on a metered connection, often in a hurry with a tender deadline.

**The site's primary job, in order of priority:**
1. Show all ten services immediately, above or near the fold, without the visitor having to hunt or scroll through a story.
2. Make it obvious the company both **supplies and installs** — that is the differentiator against pure hardware vendors.
3. Prove capability with real project photography and a real client list.
4. Make contact effortless: tap-to-call, WhatsApp, email, and a short quote form.

**Brand positioning line (use verbatim where the brief calls for it):**

> We are a leading service provider — advisory, installation and maintenance — in telecommunications and security systems. We are dedicated to providing professional, valuable and excellent services that meet our customers' needs.

**Company taglines available:** "Innovation • Quality • Security • Excellence" (from the profile — use sparingly, and never as tracked-out all-caps chrome).

---

## 2. Assumptions and decisions

These are the interpretations made from the brief. Flag any you disagree with before building.

| # | Assumption | Rationale |
|---|---|---|
| 1 | "Should be a generic AI website" is read as **should NOT look like a generic AI website**. The rest of the sentence ("but designed with human feel, UI/UX practices") confirms this. | Section 4.7 lists the specific patterns to avoid. |
| 2 | "Visitors should not structure" is read as **visitors should not have to hunt through structure** to find services. | Services appear on the home page immediately below the hero, all ten visible without pagination. |
| 3 | Content is **database-driven** with seeders, not hardcoded in Blade. | Services, products and projects all need detail pages and will change. Seeders keep the first deploy simple. |
| 4 | **No admin panel in v1.** Content updates ship via seeders/migrations. | Keeps scope tight. Phase 13 is an optional admin if the client asks. |
| 5 | Contact form writes to the database **and** sends mail. | Email deliverability in Kenya-hosted environments is unreliable; the DB record is the safety net. |
| 6 | No blog in v1, but the route namespace and schema leave room for one. | Blog is the single biggest SEO lever later. Do not build it now. |
| 7 | English only. No multilingual layer. | Regional market is English-operating for B2B. |
| 8 | Images are supplied by the client. Build against the manifest in section 15 and ship with correctly-sized placeholders if files are missing. | Do not download stock imagery. |

---

## 3. Tech stack

| Layer | Choice | Notes |
|---|---|---|
| Framework | **Laravel 12** | `composer create-project laravel/laravel scartech` |
| PHP | 8.2+ | Laravel 12 minimum |
| Templating | **Blade** with components (`resources/views/components`) | No Livewire, no Inertia, no React |
| CSS | **Tailwind CSS v4** via `@tailwindcss/vite` | CSS-first config using `@theme`; no `tailwind.config.js` |
| Build | Vite 6 (ships with Laravel 12) | |
| JS | **Alpine.js 3** (~15kb) | Mobile nav, accordions, lightbox, form states. Nothing heavier. |
| Icons | **Blade Lucide Icons** — `composer require mallardduck/blade-lucide-icons` | Consistent stroke icons, covers `cctv`, `flame`, `cable`, `scan-face`, `speaker`, `network`. No emoji, no icon fonts. |
| Database | MySQL 8 (production), SQLite (local dev) | |
| Mail | SMTP via client's `scartech.co.ke` mailbox | Configure in `.env`, never commit credentials |
| Images | `intervention/image` for responsive derivatives (optional) | Or pre-size manually — see section 15 |
| Sitemap | Hand-rolled controller (section 11.4) | No package needed |
| Deploy target | Standard LAMP/cPanel or a VPS with Nginx + PHP-FPM | Section 19 |

**Packages to install (complete list):**

```bash
composer require mallardduck/blade-lucide-icons
npm install -D tailwindcss @tailwindcss/vite
npm install alpinejs
```

Do not add any other packages without asking.

---

## 4. Design system

### 4.1 Design concept — "Signal and Structure"

The logo is a waveform — vertical bars of varying height in black and blue. The company's actual work is racks, patch panels, cable trays, fiber runs, and camera arrays: **things arranged in disciplined vertical and horizontal order.** The design language comes from that, not from generic corporate-tech visuals.

Two devices carry the identity:

1. **The waveform rule.** A thin horizontal band of vertical bars of varying height, derived from the logo, used as a section divider and as the hero's anchoring graphic. It is the one piece of visual boldness on the site. It appears at most three times per page.
2. **The rack grid.** Content that is a list of capabilities (services, specs, standards, office locations) is set as a structured index with hairline rules and a fixed left column — like reading a patch panel label strip — rather than as a field of identical rounded cards.

Spend the boldness on the hero waveform and the services index. Everything else stays quiet: generous whitespace, left-aligned text, one accent weight of blue, real photography.

### 4.2 Colour tokens

Grey, white and blue as briefed. Blue is sampled from the logo's periwinkle bars, deepened for contrast compliance.

```css
/* resources/css/app.css */
@import "tailwindcss";

@theme {
  /* Blue — primary brand */
  --color-brand-50:  #F1F5FD;
  --color-brand-100: #E0E9FA;
  --color-brand-200: #C6D7F5;
  --color-brand-300: #9DBCEC;
  --color-brand-400: #6E99E0;
  --color-brand-500: #4A79D4;   /* logo blue */
  --color-brand-600: #3560BC;   /* primary actions, AA on white */
  --color-brand-700: #2A4C97;
  --color-brand-800: #223D78;
  --color-brand-900: #16294F;   /* deep sections, footer */

  /* Grey — structural */
  --color-slate-25:  #FAFBFC;
  --color-slate-50:  #F4F6F8;
  --color-slate-100: #E9EDF2;
  --color-slate-200: #D8DEE7;
  --color-slate-300: #B9C3D0;
  --color-slate-400: #8894A6;
  --color-slate-500: #66738A;
  --color-slate-600: #4C5769;
  --color-slate-700: #363F4E;
  --color-slate-800: #232B37;
  --color-slate-900: #141A23;   /* body text, headings */

  --color-white: #FFFFFF;

  /* Functional only — never decorative */
  --color-success: #2E7D5B;
  --color-danger:  #B4452F;

  --font-display: "Archivo", ui-sans-serif, system-ui, sans-serif;
  --font-body:    "Inter", ui-sans-serif, system-ui, sans-serif;

  --radius-sm: 2px;
  --radius-md: 4px;
  --radius-lg: 8px;
}
```

**Usage rules:**
- Page background: `white`. Alternating sections: `slate-25` or `slate-50`. Never both in adjacent sections.
- Body text: `slate-700`. Headings: `slate-900`. Muted/meta: `slate-500`.
- Primary button: `brand-600` background, white text. Hover `brand-700`.
- Deep section (footer, CTA band, hero overlay): `brand-900` with `slate-200` body text.
- Borders and rules: `slate-200` at 1px. Hairlines inside dark sections: `white/12`.
- **One accent only.** No secondary orange/teal/green accent anywhere. Green and red exist solely for form validation states.
- Photographs sit on white or `slate-50`, never inside a gradient.

### 4.3 Typography

Two families, clearly distinct in role.

- **Display / headings: Archivo** (600, 700). Tight tracking (`-0.02em`) at large sizes. Its slightly condensed, engineered grotesk character suits infrastructure work.
- **Body / UI: Inter** (400, 500, 600). Neutral, excellent at small sizes on low-DPI Android screens.

Self-host via `@fontsource` or Bunny Fonts (GDPR-friendly, faster in East Africa than Google Fonts). Preload the two most-used weights.

**Type scale** (fluid via `clamp`):

| Role | Size | Family / weight | Tracking | Leading |
|---|---|---|---|---|
| Hero headline | `clamp(2.25rem, 5vw, 4rem)` | Archivo 700 | -0.03em | 1.05 |
| Page title (h1) | `clamp(2rem, 4vw, 3rem)` | Archivo 700 | -0.02em | 1.1 |
| Section title (h2) | `clamp(1.5rem, 2.5vw, 2.125rem)` | Archivo 600 | -0.02em | 1.15 |
| Card / sub title (h3) | `1.25rem` | Archivo 600 | -0.01em | 1.25 |
| Lead paragraph | `1.125rem` | Inter 400 | 0 | 1.65 |
| Body | `1rem` | Inter 400 | 0 | 1.7 |
| Small / meta | `0.875rem` | Inter 500 | 0 | 1.5 |

**Typographic rules:**
- Body copy max width **68 characters** (`max-w-[68ch]`). Never full-bleed paragraphs.
- Sentence case for all headings and buttons. Title Case only for proper nouns.
- **No all-caps eyebrow labels** above headings. If a section needs categorising, use a hairline rule plus sentence-case text at `0.875rem` in `slate-500`, or nothing at all.
- **Do not accent a single word** in a headline in a different colour or weight.
- No arrows appended to link text. If directional affordance is needed, use a Lucide icon as a sibling element with `aria-hidden="true"`.
- No monospace for decoration. Monospace is permitted only for actual technical values (IP ranges, standards codes like `TIA/EIA-568-C`).

### 4.4 Layout and spacing

- Container: `max-w-[1200px]` with `px-5 sm:px-8 lg:px-10`. A narrower `max-w-[760px]` prose container for long-form text (About, service detail body).
- Vertical section rhythm: `py-16 md:py-24`. Hero: `pt-12 pb-16 md:pt-20 md:pb-28`.
- 12-column grid on `lg`, 6-column on `md`, single column on mobile.
- **Alignment: left, throughout.** Centred text is permitted only in the CTA band and the 404 page. Left alignment reads faster and is the deliberate anti-default choice here.
- Asymmetry is encouraged: hero splits 7/5, about splits 5/7, service detail splits 8/4 with a sticky sidebar.
- Border radius: `4px` default, `8px` on images and large panels, `2px` on badges. **One radius per element class — do not put the same radius on everything.**
- Shadows: almost none. Use `border border-slate-200` for separation. A single soft shadow (`0 1px 2px rgb(20 26 35 / 0.06), 0 8px 24px -12px rgb(20 26 35 / 0.12)`) is allowed on the sticky header once scrolled and on the mobile nav sheet. Nowhere else.

### 4.5 Motion

- One orchestrated entrance on the home hero only: the waveform bars draw in, staggered 40ms apart, over 600ms. Nothing else animates on load.
- **No fade-and-slide-up on every section.** No scroll-triggered reveals.
- Interaction motion is welcome: accordion open/close (200ms ease-out), mobile nav slide (250ms), lightbox fade (150ms), button and link colour transitions (120ms).
- Wrap everything in `@media (prefers-reduced-motion: reduce) { … }` and disable transforms/opacity animation.

### 4.6 Core component inventory

Build these as Blade components in `resources/views/components/`. Each is used across multiple pages.

| Component | File | Purpose |
|---|---|---|
| Layout | `layouts/app.blade.php` | Shell: head, header, slot, footer, scripts |
| SEO head | `components/seo.blade.php` | Title, meta, OG, Twitter, canonical (section 11.1) |
| Schema | `components/schema/*.blade.php` | JSON-LD blocks (section 11.2) |
| Header | `components/site-header.blade.php` | Sticky nav, mobile sheet, phone CTA |
| Footer | `components/site-footer.blade.php` | Offices, service links, contact, NAP |
| Waveform | `components/waveform.blade.php` | Inline SVG divider, accepts `variant` and `class` |
| Button | `components/button.blade.php` | `variant`: primary, secondary, ghost, dark |
| Section heading | `components/section-heading.blade.php` | h2 + optional lead paragraph |
| Service card | `components/service-card.blade.php` | Icon, name, one-line summary, link |
| Service index row | `components/service-row.blade.php` | Dense list variant for home + footer |
| Product card | `components/product-card.blade.php` | Image, name, category, short spec |
| Project card | `components/project-card.blade.php` | Cover image, title, sector, services |
| Client logo wall | `components/client-wall.blade.php` | Grayscale logos, colour on hover |
| Stat block | `components/stat.blade.php` | Figure + label (see caveat in 10.1) |
| Breadcrumbs | `components/breadcrumbs.blade.php` | Visual + feeds BreadcrumbList schema |
| CTA band | `components/cta-band.blade.php` | Dark full-width, one headline, two actions |
| Accordion | `components/accordion.blade.php` | Alpine-driven, used for FAQ + spec tables |
| Form field | `components/form/input.blade.php`, `select`, `textarea` | Label, error, hint, aria wiring |
| Alert | `components/alert.blade.php` | Success/error after form submit |
| Lightbox | `components/lightbox.blade.php` | Alpine gallery for portfolio images |
| WhatsApp float | `components/whatsapp-button.blade.php` | Fixed bottom-right on mobile only |

### 4.7 Anti-generic guardrails

The client explicitly does not want a templated AI-looking site. These are forbidden:

- Purple, violet, or warm-cream palettes. Warm terracotta accents. Acid green on near-black.
- Full-width gradient washes used as decoration. Gradients are permitted only as a photo overlay scrim for text legibility.
- Glassmorphism, floating blurred blobs, animated mesh backgrounds.
- Every section being a grid of identically-sized rounded cards with the same shadow.
- Tracked-out ALL-CAPS eyebrow labels.
- Meta strings joined with middle dots (`Nairobi · Telecom · 2024`).
- `WORD — fragment` headings with spaced em dashes.
- A `→` character inside button or link text.
- Numbered markers `01 / 02 / 03` on content that is not an actual sequence. They are permitted **only** on the 5-phase project methodology (section 10.2), which genuinely is a sequence.
- Stock photography of generic office workers pointing at laptops. Use the client's real installation photography only.
- Vague filler copy: "empowering businesses", "cutting-edge solutions", "in today's fast-paced world". Write what the company actually does, in plain terms.
- Fake statistics. "500+ projects delivered" is not in the profile — do not invent it. See section 10.1.

---

## 5. Sitemap and routes

### 5.1 URL map

```
/                               Home
/about                          About us
/services                       Services index (all 10)
/services/{slug}                Service detail
/products                       Products index (filterable by category)
/products/{slug}                Product detail
/portfolio                      Portfolio / projects index
/portfolio/{slug}               Project detail
/contact                        Contact us + enquiry form
/request-a-quote                Quote / site survey request form
/sitemap.xml                    Generated XML sitemap
/robots.txt                     Static
```

### 5.2 `routes/web.php`

```php
<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/request-a-quote', [QuoteRequestController::class, 'create'])->name('quote.create');
Route::post('/request-a-quote', [QuoteRequestController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('quote.store');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
```

Every page has its own controller, as briefed. Route-model binding is by `slug` on all detail pages.

### 5.3 Navigation

Primary nav order (matches buyer journey, not alphabetical):

`Home · About · Services · Products · Portfolio · Contact` + a persistent **Request a quote** button (`brand-600`).

- `Services` opens a mega-panel on `lg+` listing all ten services in two columns with their icons, plus a link to the index. On mobile it is an accordion inside the nav sheet.
- The header phone number is a `tel:` link and visible from `md` up.
- Mark the active route with `aria-current="page"` and a 2px `brand-600` bottom rule.

---

## 6. Data model

### 6.1 Tables

**`services`**

| Column | Type | Notes |
|---|---|---|
| id | id | |
| name | string | e.g. "CCTV installation" |
| slug | string unique | |
| icon | string | Lucide icon name |
| tagline | string | one short line, shown on cards |
| summary | text | 2–3 sentences, used in meta description fallback |
| body | longText | HTML, the detail page narrative |
| capabilities | json | array of `{title, description}` |
| deliverables | json | array of strings — what the client receives |
| applications | json | array of strings — where it's used |
| brands | json | array of strings |
| hero_image | string nullable | |
| gallery | json nullable | array of image paths |
| meta_title | string nullable | |
| meta_description | string nullable | |
| og_image | string nullable | |
| sort_order | unsignedSmallInteger default 0 | |
| is_featured | boolean default false | |
| is_active | boolean default true | |
| timestamps | | |

**`product_categories`** — id, name, slug, description(text nullable), icon, sort_order, timestamps

**`products`** — id, product_category_id (FK, cascade on delete → restrict), name, slug unique, brand nullable, model_number nullable, summary(text), description(longText nullable), specifications(json — array of `{label, value}`), features(json), image nullable, gallery(json nullable), datasheet_path nullable, is_featured bool, is_active bool default **false**, sort_order, meta_title, meta_description, timestamps

> `is_active` defaults to **false** for products. Nothing publishes until the client confirms the model actually exists in their catalogue. See section 16.6.

**`projects`** (portfolio) — id, title, slug unique, client_name nullable, sector (string), location (string), year (smallInteger nullable), summary(text), challenge(text nullable), solution(text nullable), outcome(text nullable), cover_image, gallery(json), is_featured bool, sort_order, meta_title, meta_description, timestamps

**`project_service`** pivot — project_id, service_id

**`clients`** — id, name, logo, sector nullable, is_featured bool, sort_order, timestamps

**`contact_messages`** — id, name, email, phone, company nullable, subject nullable, message(text), source(string, default 'contact'), ip_address nullable, user_agent nullable, is_read bool default false, timestamps

**`quote_requests`** — id, name, email, phone, company nullable, service_id nullable FK, location nullable, site_type nullable, timeline nullable, budget_range nullable, details(text), needs_site_survey bool, ip_address, user_agent, status enum('new','contacted','quoted','won','lost') default 'new', timestamps

**`testimonials`** (schema only — do **not** seed) — id, author_name, author_role, company, quote(text), logo nullable, is_active default false, sort_order, timestamps

### 6.2 Models

Create `App\Models\{Service, ProductCategory, Product, Project, Client, ContactMessage, QuoteRequest, Testimonial}`.

Requirements on each:

- `$fillable` explicitly listed (no `$guarded = []`).
- `casts()` returning json columns as `'array'` and booleans as `'boolean'`.
- `getRouteKeyName(): string => 'slug'` on Service, Product, Project.
- Global-ish scopes as local scopes: `scopeActive($q) => $q->where('is_active', true)` and `scopeOrdered($q) => $q->orderBy('sort_order')->orderBy('name')`.
- Relationships: `Product::category()`, `ProductCategory::products()`, `Project::services()` (belongsToMany), `Service::projects()` (belongsToMany), `QuoteRequest::service()`.
- Accessor `Service::getImageUrlAttribute()` returning `asset($this->hero_image ?? 'images/placeholders/service.jpg')` so missing images never break the layout. Same pattern on Product and Project.

### 6.3 Company details as config, not database

Create `config/company.php`. Every phone number, email and address on the site reads from here — this guarantees NAP consistency, which matters for local SEO.

```php
<?php

return [
    'legal_name' => 'Scartech Systems Limited',
    'short_name' => 'Scartech Systems',
    'tagline'    => 'Advisory, installation and maintenance for telecom and security systems',
    'email'      => 'info@scartech.co.ke',
    'website'    => 'https://www.scartech.co.ke',

    'whatsapp'   => '254714801680', // digits only, for wa.me links

    'offices' => [
        [
            'country'  => 'Kenya',
            'label'    => 'Headquarters',
            'city'     => 'Nairobi',
            'street'   => '',            // CONFIRM WITH CLIENT — physical street address
            'phones'   => ['+254 714 801 680', '+254 720 805 816', '+254 10 124 4120'],
            'is_primary' => true,
            'lat'      => null,          // CONFIRM WITH CLIENT
            'lng'      => null,
        ],
        [
            'country' => 'Uganda',
            'label'   => 'Regional office',
            'city'    => 'Kampala',
            'street'  => '',
            'phones'  => ['+256 689 7248'],
            'is_primary' => false,
        ],
        [
            'country' => 'Rwanda',
            'label'   => 'Regional office',
            'city'    => 'Kigali',
            'street'  => '',
            'phones'  => ['+250 85 71804'],
            'is_primary' => false,
        ],
    ],

    'expansion' => ['Tanzania', 'Burundi'],

    'areas_served' => ['Kenya', 'Uganda', 'Rwanda', 'Tanzania', 'Burundi'],

    'socials' => [
        // CONFIRM WITH CLIENT — omit any that don't exist rather than linking to a 404
        'linkedin'  => null,
        'facebook'  => null,
        'x'         => null,
        'instagram' => null,
    ],

    'hours' => [
        'weekday' => '08:00–17:30',
        'saturday' => '09:00–13:00',
        'sunday' => 'Closed',
        'support' => '24/7 for clients on an SLA',
    ],
];
```

Share it with all views via a `ViewServiceProvider` (or `View::share('company', config('company'))` in `AppServiceProvider::boot()`).

---

## 7. Application structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AboutController.php
│   │   ├── ContactController.php
│   │   ├── HomeController.php
│   │   ├── PortfolioController.php
│   │   ├── ProductController.php
│   │   ├── QuoteRequestController.php
│   │   ├── ServiceController.php
│   │   └── SitemapController.php
│   └── Requests/
│       ├── StoreContactMessageRequest.php
│       └── StoreQuoteRequestRequest.php
├── Mail/
│   ├── ContactMessageReceived.php
│   └── QuoteRequestReceived.php
├── Models/
├── Providers/
│   └── ViewServiceProvider.php
└── View/
    └── Composers/            (optional — nav service list)

config/
└── company.php

database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    ├── ServiceSeeder.php
    ├── ProductCategorySeeder.php
    ├── ProductSeeder.php
    ├── ProjectSeeder.php
    └── ClientSeeder.php

resources/
├── css/app.css
├── js/app.js
└── views/
    ├── layouts/
    │   └── app.blade.php
    ├── components/          (see 4.6)
    ├── partials/
    │   ├── home/            (hero, services-index, capability, clients, cta …)
    │   └── shared/
    ├── pages/
    │   ├── home.blade.php
    │   ├── about.blade.php
    │   ├── services/index.blade.php
    │   ├── services/show.blade.php
    │   ├── products/index.blade.php
    │   ├── products/show.blade.php
    │   ├── portfolio/index.blade.php
    │   ├── portfolio/show.blade.php
    │   ├── contact.blade.php
    │   └── quote.blade.php
    ├── emails/
    │   ├── contact-message.blade.php
    │   └── quote-request.blade.php
    ├── errors/
    │   ├── 404.blade.php
    │   └── 500.blade.php
    └── sitemap.blade.php

public/
├── images/                  (see section 15)
└── robots.txt
```

---

## 8. Controllers

Every controller is thin: fetch, pass to view. No business logic in Blade beyond presentation.

**`HomeController@index`**
```php
return view('pages.home', [
    'services'        => Service::active()->ordered()->get(),
    'featuredProjects'=> Project::with('services')->where('is_featured', true)->ordered()->take(3)->get(),
    'featuredProducts'=> Product::active()->where('is_featured', true)->ordered()->take(4)->get(),
    'clients'         => Client::where('is_featured', true)->ordered()->get(),
]);
```

**`AboutController@index`** — passes `services` (for the capability list) and `clients`.

**`ServiceController@index`** — `Service::active()->ordered()->get()`.

**`ServiceController@show(Service $service)`** — abort 404 if `!$service->is_active`. Also pass:
- `relatedProjects` = `$service->projects()->take(3)->get()`
- `relatedProducts` = products in categories mapped to this service (use a simple `service_slug => category_slugs` map in `config/company.php` or a `related_category_slugs` json column — keep it simple with the config map)
- `otherServices` = 4 other active services for cross-linking.

**`ProductController@index`** — supports `?category=slug` filter. Pass `categories` and paginated `products` (12 per page, `withQueryString()`).

**`ProductController@show(Product $product)`** — 404 if inactive; pass `relatedProducts` from the same category (4).

**`PortfolioController@index`** — supports `?service=slug` and `?sector=` filters. Paginate 9.

**`PortfolioController@show(Project $project)`** — pass `$project->load('services')` and `nextProject`/`prevProject` by `sort_order`.

**`ContactController@index`** — returns the contact page with `services` for the subject dropdown.

**`ContactController@store(StoreContactMessageRequest $request)`**
```php
$message = ContactMessage::create($request->validated() + [
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
]);

Mail::to(config('company.email'))->send(new ContactMessageReceived($message));

return redirect()->route('contact.index')
    ->with('status', 'Thanks — your message has reached our team. We reply within one working day.');
```
Wrap `Mail::send` in a try/catch that logs failure but still returns success to the user (the record is saved).

**`QuoteRequestController@create` / `@store`** — same shape, richer form.

**`SitemapController@index`** — see 11.4.

---

## 9. Blade layout and header/footer specification

### 9.1 `layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#16294F">

    <x-seo
        :title="$seoTitle ?? null"
        :description="$seoDescription ?? null"
        :image="$seoImage ?? null"
        :type="$seoType ?? 'website'" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="apple-touch-icon" href="/images/brand/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-schema.organization />
    {{ $schema ?? '' }}
</head>
<body class="bg-white font-body text-slate-700 antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-white">
        Skip to content
    </a>

    <x-site-header />

    <main id="main">
        {{ $slot }}
    </main>

    <x-site-footer />
    <x-whatsapp-button />
</body>
</html>
```

### 9.2 Header

- Sticky, `h-16 md:h-20`, white background, `border-b border-slate-200`. On scroll past 20px add the single allowed shadow and reduce height to `h-14 md:h-16` (Alpine `x-data` + scroll listener, throttled).
- Left: logo (`Scartech_Systems_Logo.png`, served at `h-9 md:h-11`, with `width`/`height` attributes to prevent CLS). Wrap in a link to `/` with `aria-label="Scartech Systems — home"`.
- Centre/right: nav links, then the phone number as a `tel:` link with a `phone` icon, then the **Request a quote** button.
- Mobile (`<lg`): hamburger opens a full-height sheet from the right. Trap focus, close on `Esc`, lock body scroll, `aria-expanded` on the trigger.
- Services mega-panel: `lg+` only, opens on click (not hover — hover menus are hostile on touch-capable laptops), two columns of five, each row is icon + name + one-line tagline.

### 9.3 Footer

Dark (`bg-brand-900`, text `slate-300`), four columns on `lg`, stacked on mobile:

1. **Logo (white/knockout version) + positioning line + the four values** rendered as plain sentence-case text separated by thin vertical rules, not bullet dots.
2. **Services** — all ten as links. This is a significant internal-linking SEO win; include every one.
3. **Company** — About, Portfolio, Products, Contact, Request a quote.
4. **Offices** — Nairobi (all three numbers, `tel:` linked), Kampala, Kigali, plus "Opening soon: Tanzania, Burundi" and the email.

Bottom bar: `© {{ date('Y') }} Scartech Systems Limited. All rights reserved.` and a small waveform mark at reduced opacity.

---

## 10. Page-by-page specification

Section order matters. Build in this order within each page.

### 10.1 Home (`/`)

The single most important requirement: **all ten services visible immediately.** The hero is deliberately short so the services index starts before or right at the fold on a 1080p laptop and is one short swipe away on mobile.

**Section 1 — Hero** (`pt-12 pb-14 md:pt-16 md:pb-20`, white background)

7/5 asymmetric split on `lg`.

- Left: h1 — *"Telecom and security systems, supplied, installed and maintained."*
  Lead paragraph — the positioning line from section 1 (shortened): *"We advise, install and maintain telecommunications and electronic security systems for businesses, schools, hospitals and financial institutions across East Africa."*
  Two actions: **Request a quote** (primary) and **See our services** (secondary, anchors to the index section below).
  Below the buttons, a single line of hairline-separated facts drawn from real profile content: `Nairobi · Kampala · Kigali` rendered as three text items separated by 1px vertical rules — **not** middle dots.
- Right: the client's best rack/control-room photograph, `rounded-lg`, with the animated waveform graphic anchored to its lower-left, overlapping the image edge by ~24px. This overlap is the page's signature moment.
- Below the whole hero: the waveform rule as a full-width divider.

> **On statistics:** the company profile claims "99.99% target uptime" and "24/7 NOC monitoring". Use those two only, worded as targets/commitments, not achievements: *"99.99% uptime target"*, *"24/7 support for SLA clients"*. **Do not invent** project counts, years-in-business, or client numbers. If the client supplies real figures later, add them.

**Section 2 — Services index** (`bg-slate-25`, `py-16 md:py-20`, `id="services"`)

Heading: *"What we do"*. Lead: *"Supply, installation and maintenance across ten disciplines."*

Render all ten as a **rack-grid index**, not a card field:
- Two columns on `lg`, one on mobile.
- Each row: a 40px icon tile (`bg-brand-50`, `text-brand-600`, `rounded-md`), then the service name (h3), then the one-line tagline in `slate-500`, then the row links to the detail page.
- Rows separated by `border-t border-slate-200`. The whole row is the link target with a clear focus ring. Hover: background shifts to white and the icon tile shifts to `brand-100`.
- Bottom of the block: a text link to `/services`.

**Section 3 — Supply and installation** (white, `py-16 md:py-24`)

5/7 split. Left: heading *"We don't just sell the hardware."* and two short paragraphs explaining that Scartech handles site survey, design, procurement, installation, testing, commissioning, handover training and ongoing maintenance. Right: the five-phase methodology from the profile as a **numbered vertical sequence** (this is the one legitimate use of numbered markers — it is a real sequence):

1. Discovery and design — site surveys, layout mapping, network topology.
2. Procurement — genuine equipment from vendor partners, full warranty.
3. Deployment — cabinets, fiber backbones, cameras and access points by certified engineers.
4. Testing and commissioning — signal validation, load testing, call-routing checks, failover.
5. Handover and training — admin training, documentation, SLA onboarding.

**Section 4 — Sectors we work in** (`bg-slate-50`)

Four items from the profile with a Lucide icon each, as a simple bordered row group (not shadowed cards): Educational institutions · Corporate facilities and business parks · Financial and banking · Hospitality and retail.

**Section 5 — Selected projects** (white)

Three featured project cards from `$featuredProjects`. Image top (`aspect-[4/3]`, `object-cover`), then sector label, title, and the services used as small bordered badges. Link to `/portfolio`.

**Section 6 — Products preview** (`bg-slate-25`)

Four featured products in a 4-column grid, and a link to `/products`. If fewer than four products are active, render the section as a category list instead (see 16.6) — **do not** show empty placeholder cards.

**Section 7 — Clients** (white)

Logo wall. Grayscale at `opacity-60`, full colour at 100% on hover/focus. 6 columns on `lg`, 3 on mobile. Intro line from the profile: *"Our work includes direct contracts and sub-contracts from IT firms that rely on our engineering."*
**See section 16.5 on client logo permissions before enabling this section.**

**Section 8 — Standards and support** (`bg-brand-900`, light text)

Three items in a bordered grid using `white/12` hairlines: TIA/EIA-568-C structured cabling with Fluke-certified test reports · SIP/H.323 compliant voice with QoS tuning · ISO 27001-aligned data protection. Plus the warranty line: *12-month manufacturer warranty on supplied hardware, 90-day installation workmanship guarantee.*

**Section 9 — CTA band** (`bg-white` with a `brand-900` inset panel, `rounded-lg`)

Headline: *"Tell us about your site and we'll scope it."* Buttons: **Request a quote** and **Call +254 714 801 680**.

### 10.2 About (`/about`)

1. **Page header** — breadcrumbs, h1 *"About Scartech Systems"*, lead paragraph from the profile (end-to-end IT, telecom and electronic security across Kenya and East Africa; partnerships with global hardware and software manufacturers; clients in business, education and finance).
2. **Who we are** — 7/5 split, prose left (max 68ch), a real photo right. Content from "Our Expertise", "Our Operational Scope", "Why Choose Us".
3. **Focus, Vision, Purpose** — three columns, each with a hairline top rule in `brand-600` and the bullets from the profile pages. Sentence case headings; do not centre.
4. **Regional presence** — a table (`table-auto`, `border-collapse`, hairline rules) listing Kenya/Uganda/Rwanda with cities and phone numbers, then Tanzania and Burundi marked "Opening soon" in `slate-400`. Read from `config('company.offices')`.
5. **Our team and philosophy** — the paragraph from the profile about consultants and field engineers, collaborative culture.
6. **Partners** — the vendor logo/name row: Cisco, Avaya, Grandstream, Microsoft, Polycom, Yealink, Digium, D-Link, NEC, Panasonic, LG Ericsson (iPECS), Hikvision (**confirm**). Render as bordered text chips if logo files are unavailable — safer than hotlinking vendor marks.
7. **CTA band.**

### 10.3 Services index (`/services`)

1. Page header with breadcrumbs, h1 *"Our services"*, lead: *"Supply, installation and maintenance across telecommunications, IT and electronic security."*
2. All ten services as **larger cards** here (2-col `md`, 3-col `lg`): icon, name, tagline, three capability bullets, and a link reading "About [service name]" — never "Read more" (bad for accessibility and SEO).
3. A short band: *"Every engagement includes a site survey, documented design, certified installation, testing and a maintenance plan."*
4. CTA band.

### 10.4 Service detail (`/services/{slug}`)

Template used by all ten. 8/4 split on `lg`.

**Main column:**
1. Breadcrumbs → h1 (service name) → tagline → summary paragraph.
2. Hero image (16/9) if available.
3. `body` rich text.
4. **What we deliver** — `capabilities` rendered as a definition-style list: bold title, description below, separated by hairlines.
5. **Where it's used** — `applications` as bordered inline chips.
6. **Brands we work with** — `brands` as text chips (only if non-empty).
7. **Related projects** — up to 3 project cards, if any.
8. **Related products** — up to 4 product cards, if any active.
9. Inline CTA: *"Request a site survey for [service name]"* linking to `/request-a-quote?service={slug}` (the quote form pre-selects the service from the query string).

**Sticky sidebar (`lg:sticky lg:top-28`):**
- A compact contact card: phone numbers, email, WhatsApp, and a "Request a quote" button.
- **Other services** — a hairline list of the other nine (or a subset of four) for internal linking.

### 10.5 Products index (`/products`)

1. Page header. h1 *"Products we supply"*. Lead: *"Genuine equipment from our vendor partners, supplied with installation, configuration and warranty support."*
2. Category filter: horizontal scrollable pill row on mobile, sidebar list on `lg`. Filtering is server-side via `?category=`. "All products" resets.
3. Product grid, 12 per page, paginated with Laravel's Tailwind pagination views (customise to match the palette — no default purple).
4. Empty state (if a category has no active products): *"We supply equipment in this category on request. Tell us what you need and we'll quote it."* plus a quote button. This is the invitation-to-act pattern, not an apology.
5. CTA band.

### 10.6 Product detail (`/products/{slug}`)

- Breadcrumbs → 7/5 split: gallery left (main image + thumbnail strip, Alpine lightbox), details right.
- Right column: category label (link), h1 product name, brand and model, summary, key features list, and two actions — **Request a quote** (pre-fills product name) and **Call us**. No prices anywhere.
- Below: `specifications` as a two-column key/value table with hairline rows.
- Related products from the same category.

> **No pricing on the site.** The profile gives no prices and this is a quotation-driven business. Every product action leads to a quote request.

### 10.7 Portfolio index (`/portfolio`)

1. Page header. h1 *"Our work"*. Lead from the profile: *"Executed installations — structured cabling, surveillance control rooms, and biometric access."*
2. Filters: by service and by sector, server-side via query string.
3. Grid of project cards, 9 per page. Card: cover image (`aspect-[3/2]`), sector, title, location and year on one hairline-separated line.
4. CTA band.

### 10.8 Project detail (`/portfolio/{slug}`)

- Breadcrumbs → h1 → a meta strip (client, sector, location, year) as a bordered 4-up grid, not dot-separated text.
- Cover image full width (`aspect-[16/7]`).
- Narrative: Challenge / Solution / Outcome as three prose blocks with hairline-ruled headings. Omit any block that is empty rather than printing a heading with nothing under it.
- Services used — linked badges to the service detail pages.
- Gallery — masonry-ish grid with lightbox. Every image needs a real `alt`.
- Prev/next project navigation at the foot.
- CTA band.

### 10.9 Contact (`/contact`)

1. Page header. h1 *"Contact us"*. Lead: *"Tell us what you need. We reply within one working day."*
2. 6/6 split:
   - **Left — the form** (fields in section 12.1). Above it, a note: *"For a priced proposal, use the quote request form instead."* linking to `/request-a-quote`.
   - **Right — contact details:** Nairobi HQ block with all three phone numbers as `tel:` links, email as `mailto:`, WhatsApp link. Then Kampala and Kigali blocks. Then business hours from config. Then a note about 24/7 SLA support.
3. Map: embed only once the client confirms the physical address and coordinates. Until then, omit the map entirely — **do not** embed a generic "Nairobi" pin. Load the iframe with `loading="lazy"` and behind a click-to-load placeholder for performance and privacy.
4. Offices table (same component as About).

### 10.10 Quote request (`/request-a-quote`)

Single-column, `max-w-[720px]`, no distractions. Fields in section 12.2. Reads `?service=` and `?product=` from the query string to pre-select. On success, redirect to the same route with a `status` flash rendered in a success alert above the form, and the form reset.

### 10.11 Error pages

- `404` — h1 *"We couldn't find that page."* Body: *"It may have moved. Try our services, products or portfolio."* with three links plus a contact link. Centred is acceptable here.
- `500` — h1 *"Something went wrong on our end."* Body with the phone number and email.

---

## 11. SEO implementation

### 11.1 `<x-seo>` component

```blade
@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'noindex' => false,
])

@php
    $siteName = config('company.short_name');
    $fullTitle = $title
        ? $title . ' | ' . $siteName
        : $siteName . ' | IT, Telecom and Security Systems in Kenya';
    $desc = $description ?? 'Scartech Systems supplies, installs and maintains CCTV, access control, VoIP, fiber, fire and PA systems for businesses across Kenya, Uganda and Rwanda.';
    $img = $image ? asset($image) : asset('images/brand/og-default.jpg');
    $canonical = url()->current();
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($desc), 155, '') }}">
<link rel="canonical" href="{{ $canonical }}">
@if($noindex)<meta name="robots" content="noindex, nofollow">@else<meta name="robots" content="index, follow, max-image-preview:large">@endif

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($desc), 155, '') }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $img }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_KE">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($desc), 155, '') }}">
<meta name="twitter:image" content="{{ $img }}">
```

Add `?noindex` on paginated pages beyond page 1 is **not** recommended — instead emit `rel="prev"`/`rel="next"` is deprecated; simply let them index with unique canonical URLs including the query string.

**Title patterns (keep under 60 characters):**

| Page | Title |
|---|---|
| Home | `Scartech Systems \| IT, Telecom and Security Systems in Kenya` |
| About | `About us` |
| Services index | `Our services` |
| Service detail | `{Service name} in Kenya` — e.g. `CCTV installation in Kenya` |
| Products index | `Products we supply` |
| Product detail | `{Product name}` |
| Portfolio index | `Our work` |
| Project detail | `{Project title}` |
| Contact | `Contact us` |
| Quote | `Request a quote` |

Each page passes `$seoTitle` and `$seoDescription` to the layout. Service and product pages fall back to `meta_title ?? name` and `meta_description ?? summary`.

### 11.2 Structured data (JSON-LD)

Create `resources/views/components/schema/`:

**`organization.blade.php`** — rendered on every page. Emits `Organization` **and** `LocalBusiness` for the Nairobi HQ:

```blade
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => ['Organization', 'LocalBusiness'],
    '@id' => url('/') . '#organization',
    'name' => config('company.legal_name'),
    'alternateName' => config('company.short_name'),
    'url' => url('/'),
    'logo' => asset('images/brand/scartech-logo.png'),
    'image' => asset('images/brand/og-default.jpg'),
    'email' => config('company.email'),
    'telephone' => config('company.offices.0.phones.0'),
    'description' => 'Supply, installation and maintenance of IT, telecommunications and electronic security systems across East Africa.',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Nairobi',
        'addressCountry' => 'KE',
    ],
    'areaServed' => collect(config('company.areas_served'))
        ->map(fn ($c) => ['@type' => 'Country', 'name' => $c])->all(),
    'sameAs' => array_values(array_filter(config('company.socials'))),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
```

Add `hasOfferCatalog` listing the ten services on the home page only.

**`service.blade.php`** — on service detail: `@type: Service`, `name`, `description`, `provider` (`@id` reference to `#organization`), `areaServed`, `serviceType`.

**`product.blade.php`** — on product detail: `@type: Product`, `name`, `brand`, `description`, `image`. **Omit `offers` entirely** — there are no prices, and a fake `offers` block risks a manual action.

**`breadcrumbs.blade.php`** — `BreadcrumbList` on every page except home. Generate from the same array the visual breadcrumb component uses so they can never drift apart.

**`website.blade.php`** — `WebSite` with `@id`, on home only. No `SearchAction` (there is no site search).

### 11.3 On-page SEO rules

- Exactly one `<h1>` per page. Heading levels never skip (`h1 → h2 → h3`).
- Slugs are short, hyphenated, lowercase, no stop words: `cctv-installation`, not `our-cctv-installation-services`.
- Every image has a descriptive `alt`. Decorative SVGs get `aria-hidden="true"` and empty `alt`. Never stuff keywords into alt text.
- Internal links use descriptive anchor text ("About CCTV installation"), never "click here" or "read more".
- The footer links to all ten services from every page — this is the main internal link graph.
- Service detail pages cross-link to related projects, related products and four sibling services.
- Add `hreflang` only if regional sub-sites are built later. Not in v1.
- Target one primary phrase per service page, naturally placed in h1, first paragraph, one h2, and the meta description. Suggested primaries: `CCTV installation Kenya`, `access control systems Nairobi`, `fiber optic installation Kenya`, `VoIP phone systems Kenya`, `fire alarm system installation Nairobi`, `electric fence installation Kenya`, `PA system installation Kenya`, `POS systems Kenya`, `structured cabling Nairobi`, `IT support Nairobi`.
- **Do not** create doorway pages for every city. If local landing pages are wanted later, write genuinely distinct content per city.

### 11.4 `sitemap.xml`

`SitemapController@index` returns `response()->view('sitemap', [...])->header('Content-Type', 'text/xml')`.

Include: home (priority 1.0, weekly), services index (0.9), each active service (0.8), products index (0.8), each active product (0.6), portfolio index (0.8), each project (0.6), about (0.7), contact (0.7), quote (0.7). `lastmod` from `updated_at`. Cache the response for 24 hours.

### 11.5 `robots.txt`

```
User-agent: *
Allow: /
Disallow: /storage/
Disallow: /vendor/

Sitemap: https://www.scartech.co.ke/sitemap.xml
```

### 11.6 Technical SEO checklist

- Force HTTPS and a single canonical host (`www` or non-`www` — pick one, 301 the other at the web-server level).
- Trailing-slash consistency: no trailing slashes. Laravel handles this by default.
- Custom 404 returns a real `404` status code.
- Add `\URL::forceScheme('https')` in `AppServiceProvider` when `app()->environment('production')`.
- Register the site in Google Search Console and Bing Webmaster Tools post-launch; submit the sitemap.
- Add Google Analytics 4 or Plausible **only after** the client decides — and behind a config flag so it can be disabled.

---

## 12. Forms

### 12.1 Contact form fields

| Field | Type | Validation |
|---|---|---|
| name | text | `required|string|max:120` |
| email | email | `required|email:rfc,dns|max:180` |
| phone | tel | `required|string|max:32` |
| company | text | `nullable|string|max:160` |
| subject | select (services + "General enquiry" + "Support") | `required|string|max:160` |
| message | textarea | `required|string|min:20|max:4000` |
| website | honeypot (hidden) | `prohibited` — must be empty |

### 12.2 Quote request fields

name, email, phone, company, **service** (select, pre-fillable), **product** (hidden, pre-fillable), location/town, site type (select: Office, School/campus, Hospital, Bank/SACCO, Hotel/restaurant, Retail, Residential, Industrial, Other), estimated timeline (select: Immediately, Within a month, 1–3 months, Planning/budgeting), needs site survey (checkbox), details (textarea, `required|min:20`), honeypot.

### 12.3 Form implementation rules

- Use Form Request classes with custom `messages()` written in plain language: *"Enter a phone number we can reach you on."* Not *"The phone field is required."*
- Errors render inline below the field, `text-danger`, with `aria-describedby` wiring and `aria-invalid="true"`.
- Old input is repopulated with `old()` on every field, including selects and the checkbox.
- Success: redirect back with `->with('status', ...)` and render `<x-alert type="success">`. Move focus to the alert (`tabindex="-1"` + Alpine `$el.focus()`) so screen-reader users hear it.
- Submit button shows a disabled/"Sending…" state via Alpine on submit to prevent double posts.
- Honeypot field: `<input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">`.
- Rate limiting via the `throttle:5,1` middleware already on the routes.
- **No CAPTCHA in v1.** Honeypot plus throttling is sufficient for this traffic volume and avoids a third-party dependency. Revisit only if spam appears.
- Mailables use markdown or a simple Blade template, are queued only if a queue worker is confirmed in production — otherwise send synchronously inside a try/catch.
- Set `MAIL_FROM_ADDRESS` to a `@scartech.co.ke` address and `Reply-To` to the submitter's email so the team can reply directly.

---

## 13. Accessibility and responsiveness

**Breakpoints:** design mobile-first. Test at 360, 390, 768, 1024, 1280, 1440, 1920.

- Nothing horizontally scrolls at 360px. Check long phone numbers, tables and the product filter row.
- Tables (offices, specifications) get a horizontally scrollable wrapper on mobile with a visible edge fade, or reflow to stacked key/value pairs below `sm`.
- Tap targets minimum 44×44px.
- Images: `loading="lazy"` on everything except the hero image, which gets `fetchpriority="high"`. Always set `width` and `height`.
- Contrast: all text meets WCAG AA (4.5:1 body, 3:1 for large text). `slate-400` on white is **only** for non-essential meta and large text — verify each use.
- Visible focus ring everywhere: `focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600`. Never `outline: none` without a replacement.
- Mobile nav: focus trap, `Esc` to close, `aria-expanded`, `aria-controls`, body scroll lock.
- Lightbox: same focus trap rules, `Esc` closes, arrow keys navigate, `role="dialog"` and `aria-modal="true"`.
- Accordions: `<button aria-expanded aria-controls>` toggling a region, not a `<div onclick>`.
- Icon-only buttons (hamburger, lightbox close, WhatsApp) need `aria-label`.
- `prefers-reduced-motion` respected globally.
- Test the whole site with keyboard only before sign-off.

---

## 14. Performance

Targets on a mid-range Android over 4G:

| Metric | Target |
|---|---|
| Lighthouse Performance (mobile) | ≥ 90 |
| Lighthouse Accessibility | ≥ 95 |
| Lighthouse Best Practices | ≥ 95 |
| Lighthouse SEO | 100 |
| LCP | < 2.5s |
| CLS | < 0.05 |
| Total JS shipped | < 40KB gzipped |

Implementation:
- Serve WebP with a JPEG fallback via `<picture>`. Generate `640w / 1024w / 1600w` derivatives and use `srcset` + `sizes`.
- Hero image preloaded (`<link rel="preload" as="image" imagesrcset=...>`).
- Fonts: `font-display: swap`, preload the two critical weights, subset to `latin`.
- No JS libraries beyond Alpine. No jQuery, no slider libraries — build the thumbnail strip and logo wall with CSS scroll-snap.
- Run `npm run build` and confirm the CSS bundle is under 30KB gzipped (Tailwind purges unused classes automatically in v4 through content scanning).
- Enable route, view and config caching in production (`php artisan optimize`).
- Add cache headers for `/images` and built assets at the web-server level (1 year, immutable for hashed assets).

---

## 15. Image manifest

The client supplies all photography. Create this structure and commit correctly-sized neutral placeholders (solid `slate-100` with the filename rendered) for anything missing, so layout is never broken by an absent file.

```
public/images/
├── brand/
│   ├── scartech-logo.png            (supplied — colour, transparent bg)
│   ├── scartech-logo-white.svg      (knockout for footer — derive if not supplied)
│   ├── og-default.jpg               1200×630
│   ├── apple-touch-icon.png         180×180
│   └── favicon.ico
├── hero/
│   └── home-hero.jpg                1600×1200, a real rack or control-room photo
├── services/
│   ├── it-solutions.jpg             1600×900
│   ├── cctv-installation.jpg
│   ├── data-voice-solutions.jpg
│   ├── sound-pa-solutions.jpg
│   ├── event-management.jpg
│   ├── fire-system.jpg
│   ├── electric-fence.jpg
│   ├── pos-systems.jpg
│   ├── access-control-systems.jpg
│   └── fiber-installation.jpg
├── projects/
│   ├── data-voice-cabinet-rack-1.jpg
│   ├── data-voice-cabinet-rack-2.jpg
│   ├── high-density-patching.jpg
│   ├── cctv-server-cabinet.jpg
│   ├── cctv-control-room-video-wall.jpg
│   ├── cctv-preventive-maintenance.jpg
│   └── biometric-access-control-cabinet.jpg
├── products/
│   └── {product-slug}.jpg           1200×1200, product on white
├── clients/
│   └── {client-slug}.png            transparent, max 400px wide
├── partners/
│   └── {vendor-slug}.svg            optional — see 10.2 note
└── placeholders/
    ├── service.jpg
    ├── product.jpg
    └── project.jpg
```

**Naming rule:** lowercase, hyphenated, matches the record slug exactly. This lets the seeders reference images predictably.

**Alt text rule:** describe the subject and context. `"Floor-to-ceiling data and voice cabinet with high-density patch panels installed at a Nairobi office"` — not `"CCTV installation Kenya services"`.

---

## 16. Seed content

### 16.1 The ten services

Seed exactly these, in this `sort_order`. All copy below is ready to use.

| # | Name | Slug | Lucide icon |
|---|---|---|---|
| 1 | IT solutions | `it-solutions` | `server-cog` |
| 2 | CCTV installation | `cctv-installation` | `cctv` |
| 3 | Data and voice solutions | `data-voice-solutions` | `network` |
| 4 | Sound and PA solutions | `sound-pa-solutions` | `speaker` |
| 5 | Event management | `event-management` | `calendar-check` |
| 6 | Fire systems | `fire-system` | `flame` |
| 7 | Electric fence | `electric-fence` | `zap` |
| 8 | POS systems | `pos-systems` | `receipt` |
| 9 | Access control systems | `access-control-systems` | `scan-face` |
| 10 | Fiber installation | `fiber-installation` | `cable` |

**1. IT solutions**
- Tagline: Networks, servers and cloud that stay up.
- Summary: We design, supply and support the IT backbone your business runs on — from structured networks and switching to servers, Microsoft 365 and day-to-day support. One team handles the design, the hardware and the maintenance.
- Capabilities: *Network design and switching* — Layer 2 and Layer 3 topologies, VLAN segmentation, routing and bandwidth prioritisation for offices, campuses and multi-site businesses. · *Servers and storage* — specification, supply, installation and configuration of on-premise servers, NAS and backup hardware. · *Microsoft 365 and cloud* — email migration, Exchange, SharePoint, OneDrive and Teams deployment with data protection policies. · *Endpoint and network security* — firewall deployment, access policies, patching and backup routines. · *IT support and SLA* — remote and on-site support with response times agreed up front.
- Applications: Corporate offices, Universities and schools, Banks and SACCOs, Hospitals, Multi-branch retail
- Brands: Cisco, D-Link, Microsoft, HP, Dell

**2. CCTV installation**
- Tagline: See every corner, day and night, from anywhere.
- Summary: High-definition IP surveillance from a single-building camera set to a multi-site system with a staffed control room. We survey the site, engineer the coverage, install and commission it, then keep it running.
- Capabilities: *Site survey and coverage design* — camera placement planned around actual sightlines, lighting and the assets you need covered. · *IP and HD camera installation* — fixed, PTZ, dome and bullet cameras with night vision and weatherproofing for external runs. · *Recording and storage* — NVR and DVR sizing for your required retention period, with RAID and off-site backup options. · *Control rooms and video walls* — multi-screen monitoring stations for security teams. · *Remote access* — secure viewing from phone, tablet or laptop. · *Preventive maintenance* — scheduled cleaning, focus checks, firmware updates and storage health reports.
- Applications: Corporate offices, Retail and shopping complexes, Schools and universities, Warehouses and yards, Residential estates
- Brands: Hikvision, Dahua, Samsung Techwin, Axis *(CONFIRM WITH CLIENT)*

**3. Data and voice solutions**
- Tagline: Structured cabling and IP telephony, certified and documented.
- Summary: The cabling and phone system that everything else depends on. We install certified structured cabling and data/voice cabinets, then deploy IP-PBX telephony over the same network — IVR, call recording, voicemail to email and CRM integration included.
- Capabilities: *Structured cabling* — Cat6/Cat6A copper installed to TIA/EIA-568-C, with Fluke-certified test reports, labelling and cable tray management. · *Data and voice cabinets* — rack build, MDF termination, patch panel layout and high-density patching. · *IP-PBX and VoIP* — on-premise or hosted phone systems with extensions across offices and remote staff. · *SIP trunking* — connect to your provider and cut line costs. · *Call features* — IVR menus, call queuing and routing, voicemail to email, automated call recording. · *CRM and mobility integration* — desk phones, softphones and mobile apps on one extension plan.
- Applications: Contact centres, Corporate head offices, Hotels, Hospitals, Campuses
- Brands: Cisco, Avaya, Yealink, Grandstream, Panasonic, NEC, Digium, LG Ericsson (iPECS)

**4. Sound and PA solutions**
- Tagline: Announcements, paging and background audio that carry.
- Summary: Public address and sound reinforcement designed for the room and the building — zoned paging, background music, evacuation announcements and boardroom audio, installed and tuned on site.
- Capabilities: *Zoned PA systems* — independent audio zones for floors, wings or outdoor areas with central paging. · *Evacuation and emergency announcement* — voice alarm integration with the fire system. · *Conference and boardroom audio* — ceiling and table microphones, DSP mixing, amplifiers and speaker layout. · *Background music distribution* — for retail floors, restaurants, lobbies and waiting areas. · *School and campus systems* — bell scheduling, assembly and field coverage. · *Tuning and commissioning* — on-site level balancing and coverage testing.
- Applications: Schools and universities, Houses of worship, Shopping malls, Factories and warehouses, Hotels and conference centres
- Brands: Bosch, TOA, Yamaha, JBL *(CONFIRM WITH CLIENT)*

**5. Event management**
- Tagline: Sound, screens and connectivity for events that can't fail.
- Summary: Technical production for conferences, launches, AGMs and functions — PA and sound, LED screens and projection, delegate microphone systems, event Wi-Fi and live streaming, with a crew on site throughout.
- Capabilities: *Sound and PA for events* — line arrays, stage monitoring, wireless microphones and mixing. · *Screens and projection* — LED walls, projectors and confidence monitors. · *Conference and delegate systems* — chairman and delegate microphone units with voting and interpretation options. · *Event connectivity* — temporary high-density Wi-Fi and wired uplinks for registration and streaming. · *Live streaming and recording* — multi-camera capture and streaming to your platform. · *On-site technical crew* — setup, rehearsal, live operation and strike.
- Applications: Corporate conferences, AGMs, Product launches, Graduations, Government and NGO forums

**6. Fire systems**
- Tagline: Detection, alarm and evacuation, installed to standard.
- Summary: Addressable and conventional fire detection and alarm systems — panels, detectors, sounders and call points — installed, commissioned and documented, with integration to access control so doors release safely.
- Capabilities: *Fire alarm panels* — addressable and conventional systems sized to the building and its zones. · *Detection devices* — smoke, heat, multi-sensor and beam detectors positioned to the building layout. · *Alarm and notification* — sounders, strobes, manual call points and voice evacuation integration. · *Access control interlock* — automatic fail-safe door release on alarm. · *Commissioning and documentation* — full cause-and-effect testing with as-built documentation for your inspection. · *Maintenance and testing* — scheduled device testing, battery checks and panel servicing.
- Applications: Office towers, Hotels, Schools, Hospitals, Warehouses and industrial plants
- Note in body: *We install and maintain detection and alarm systems. Where a project requires certification or suppression works falling under a licensed contractor, we coordinate with the appropriate specialists.* **(CONFIRM WITH CLIENT — do not claim regulatory certification the company does not hold.)**

**7. Electric fence**
- Tagline: A perimeter that reacts before anyone reaches the building.
- Summary: Perimeter electric fencing designed, supplied and installed — wall-top or freestanding, zoned, with energisers, alarm integration and a maintenance plan.
- Capabilities: *Perimeter design and zoning* — the fence split into monitored zones so an alarm tells you exactly where the breach is. · *Wall-top and freestanding installation* — brackets, insulators, wires and tensioning for masonry walls or standalone posts. · *Energisers and control* — mains and solar-backed energisers with keypad control and voltage monitoring. · *Alarm and monitoring integration* — siren, strobe, control room and phone notification, linked to CCTV where installed. · *Gate and razor wire integration* — continuous perimeter including gates and vehicle entries. · *Maintenance* — vegetation clearance, voltage testing, insulator replacement and fault tracing.
- Applications: Residential estates, Warehouses and yards, Schools, Factories, Farms and depots

**8. POS systems**
- Tagline: Tills, stock and reporting that agree with each other.
- Summary: Point-of-sale hardware and software for retail and hospitality — terminals, printers, scanners and cash drawers, set up with inventory control and multi-branch reporting, then supported.
- Capabilities: *POS hardware supply* — terminals, touch monitors, thermal receipt printers, barcode scanners and cash drawers. · *Retail and hospitality software* — configured for your products, prices, tax and shift patterns. · *Inventory and stock control* — stock levels, reorder points and stock-take support across branches. · *Multi-branch reporting* — consolidated sales, margin and shift reports from every till. · *Integration* — links to accounting, CRM and payment terminals. · *Staff training and support* — till training at handover plus ongoing support.
- Applications: Supermarkets and retail chains, Restaurants and cafés, Hotels, Pharmacies, Hardware and distribution
- Brands: *(CONFIRM WITH CLIENT)*

**9. Access control systems**
- Tagline: Know who goes where, and when.
- Summary: Biometric and card-based access control with time and attendance — fingerprint, facial recognition, RFID and turnstiles, centrally managed and integrated with your fire and CCTV systems.
- Capabilities: *Biometric verification* — fingerprint, facial recognition and iris readers for doors and restricted areas. · *Card and fob access* — RFID badges with issuing, revocation and lost-card handling. · *Door hardware* — magnetic locks, electric strikes, exit buttons, turnstiles and boom-gate integration. · *Time and attendance* — automatic clock-in records exported to your payroll. · *Central management* — one console for policies, schedules, zones and audit trails across sites. · *Visitor management* — temporary credentials with expiry and full visit logs.
- Applications: Server rooms and data centres, Bank and SACCO branches, Manufacturing plants, Corporate offices, Campuses and hostels

**10. Fiber installation**
- Tagline: Backbones that carry everything, tested and certified.
- Summary: Optical fiber design and installation — ducted, aerial or blown — with professional splicing, termination and OTDR-certified test results for campus links, building risers and inter-site backbones.
- Capabilities: *Route survey and design* — duct, aerial and blown-fiber routes planned around the site and its civil constraints. · *Installation* — single-mode and multi-mode fiber pulled, blown or strung, with correct bend radius and protection. · *Splicing and termination* — fusion splicing, pigtails, patch panels and ODF build. · *OTDR testing and certification* — loss budgets verified and documented for every link. · *Campus and inter-building links* — connecting blocks, gatehouses, warehouses and remote offices. · *Fault location and repair* — rapid response fiber fault tracing and re-splicing.
- Applications: Multi-building campuses, Industrial parks, Hospitals, ISP and last-mile links, High-rise risers

### 16.2 Service page body copy

For each service, the `body` field should be two to three short paragraphs following this shape:

1. What the system does and why a client installs it — in the client's language, not the vendor's.
2. What Scartech specifically does end to end: survey → design → supply → install → test → hand over → maintain.
3. One paragraph on the standards, documentation or support that comes with it.

Keep each body under 220 words. Long copy does not rank better; specific copy does.

### 16.3 Product categories

Seed these eight, `is_active = true`:

`telephony-voip` (Telephony and VoIP) · `networking-fiber` (Networking and fiber) · `cctv-surveillance` (CCTV and surveillance) · `access-control-biometrics` (Access control and biometrics) · `fire-safety` (Fire safety) · `sound-av` (Sound and AV) · `pos-hardware` (POS hardware) · `perimeter-security` (Perimeter security)

### 16.4 Portfolio projects

Seed these from the profile's project gallery. Each needs `challenge`, `solution` and `outcome` written from what the photograph actually shows — do not invent client names or figures.

| Title | Slug | Sector | Services |
|---|---|---|---|
| Data and voice cabinet — network rack build | `data-voice-cabinet-network-rack` | Corporate | Data and voice solutions |
| High-density patching installation | `high-density-patching-installation` | Corporate | Data and voice solutions |
| CCTV server cabinet deployment | `cctv-server-cabinet-deployment` | Corporate | CCTV installation |
| CCTV control room and video wall | `cctv-control-room-video-wall` | Corporate | CCTV installation |
| CCTV preventive maintenance programme | `cctv-preventive-maintenance` | Corporate | CCTV installation |
| Biometric and access control cabinet | `biometric-access-control-cabinet` | Corporate | Access control systems |

`client_name` stays `null` on all six until the client confirms which names may be published. The card and detail page must render correctly with a null client (show the sector instead).

### 16.5 Client logos — important

The company profile shows roughly 35 client logos including government bodies, embassies, international NGOs and listed brands.

**Before enabling the client wall:**
1. Ask Scartech to confirm, in writing, which client names and logos they are permitted to display. Many corporate and government clients require written consent for logo use, and embassies and revenue authorities in particular often prohibit it.
2. Seed only confirmed clients. Put the rest in the seeder commented out.
3. Use supplied logo files, not logos scraped from the web.

Build the `ClientSeeder` with a clearly marked `// PENDING CONFIRMATION` block, and set `is_featured = false` on anything unconfirmed so it never renders.

### 16.6 Products — the placeholder rule

Do not seed invented model numbers, specs or prices. Instead:

- Seed the eight categories with real descriptions of what Scartech supplies in each.
- Seed **one** example product per category with `is_active = false` and a `// TEMPLATE — replace with real catalogue data` comment, so the templates can be styled and reviewed.
- The products index must render gracefully when few or no products are active: show the category list with a "request a quote for this category" action instead of an empty grid.

This keeps the site honest at launch and lets the client populate the catalogue without a rebuild.

---

## 17. Build phases

Work through these in order. Stop at the end of each phase for review.

### Phase 1 — Foundation
- [ ] `composer create-project laravel/laravel scartech`, git init, `.env` configured with SQLite for local dev
- [ ] Install Tailwind v4 via `@tailwindcss/vite`, wire into `vite.config.js`
- [ ] Write `resources/css/app.css` with the full `@theme` block from 4.2
- [ ] Install and configure Alpine in `resources/js/app.js`
- [ ] Install `blade-lucide-icons`
- [ ] Set up fonts (Archivo + Inter) with preload
- [ ] Create `config/company.php` and share it with all views
- [ ] Create the folder structure from section 7
- **Check:** `npm run dev` runs, a test page renders with brand colours and both fonts.

### Phase 2 — Data layer
- [ ] All migrations from section 6.1
- [ ] All models with fillable, casts, scopes, relationships, route key names, image accessors
- [ ] `ServiceSeeder` with all ten services and full copy from 16.1
- [ ] `ProductCategorySeeder`, `ProductSeeder` (templates, inactive), `ProjectSeeder`, `ClientSeeder`
- **Check:** `php artisan migrate:fresh --seed` succeeds; `Service::active()->ordered()->count() === 10`.

### Phase 3 — Layout shell
- [ ] `layouts/app.blade.php` with skip link and slots
- [ ] `<x-seo>` component
- [ ] `<x-site-header>` — desktop nav, services mega-panel, mobile sheet with focus trap
- [ ] `<x-site-footer>` — four columns, all ten service links, offices from config
- [ ] `<x-whatsapp-button>`
- **Check:** header and footer render on a blank page; mobile nav is keyboard operable; nothing overflows at 360px.

### Phase 4 — Design primitives
- [ ] `<x-button>` with four variants and correct focus rings
- [ ] `<x-waveform>` — inline SVG derived from the logo, with the load animation
- [ ] `<x-section-heading>`, `<x-breadcrumbs>`, `<x-cta-band>`, `<x-alert>`, `<x-accordion>`
- [ ] Form field components with full aria wiring
- **Check:** a component gallery route (temporary, deleted later) shows every variant at every breakpoint.

### Phase 5 — Home page
- [ ] `HomeController` + all nine sections from 10.1
- [ ] `<x-service-row>` rack-grid index — all ten services
- [ ] `<x-project-card>`, `<x-product-card>`, `<x-client-wall>`, `<x-stat>`
- **Check:** all ten services are visible without pagination; hero LCP image is preloaded; Lighthouse mobile ≥ 85 at this stage.

### Phase 6 — Services
- [ ] `ServiceController@index` and `@show`
- [ ] Services index page
- [ ] Service detail template with sticky sidebar, related projects, related products, sibling services
- [ ] `<x-schema.service>`
- **Check:** all ten detail pages render, each with unique title and meta description; 404 on an inactive slug.

### Phase 7 — Products
- [ ] `ProductController` with category filtering and pagination
- [ ] Index with filter UI and the graceful empty state
- [ ] Detail with gallery, lightbox, specification table
- [ ] `<x-schema.product>` without `offers`
- **Check:** filter persists through pagination; empty category shows the invitation state, not a blank grid.

### Phase 8 — Portfolio
- [ ] `PortfolioController` with service and sector filters
- [ ] Index grid and detail page with challenge/solution/outcome blocks that omit cleanly when empty
- [ ] Lightbox gallery with keyboard navigation
- [ ] Prev/next navigation
- **Check:** a project with a null client and empty outcome renders without stray headings.

### Phase 9 — About and Contact
- [ ] About page, all seven sections
- [ ] Contact page with the offices block and form
- [ ] Quote request page with query-string pre-fill
- [ ] Form Requests, Mailables, email templates, success/error handling
- **Check:** submit both forms; confirm DB rows created and mail attempted; confirm mail failure does not break the user-facing success path.

### Phase 10 — SEO
- [ ] Per-page titles and descriptions wired through `<x-seo>`
- [ ] All JSON-LD components, validated against the Rich Results Test
- [ ] `SitemapController` + `sitemap.blade.php`, cached
- [ ] `robots.txt`
- [ ] Heading hierarchy audit, alt text audit, internal link audit
- **Check:** Lighthouse SEO = 100 on every page type; no schema errors.

### Phase 11 — Polish and QA
- [ ] Error pages
- [ ] Responsive sweep at all seven widths
- [ ] Keyboard-only pass over the whole site
- [ ] Contrast check on every text/background pairing
- [ ] `prefers-reduced-motion` verified
- [ ] Image optimisation, WebP derivatives, srcset
- [ ] Delete the temporary component gallery route
- **Check:** full acceptance checklist in section 18.

### Phase 12 — Deployment prep
- [ ] Production `.env` template documented (no secrets committed)
- [ ] `php artisan optimize` in the deploy script
- [ ] HTTPS forcing, canonical host redirect
- [ ] Deployment notes in `README.md`
- **Check:** `npm run build` succeeds; app boots with `APP_DEBUG=false`.

### Phase 13 — Optional, only if the client asks
- [ ] Minimal admin (Laravel Breeze auth + simple CRUD, or Filament) for services, products, projects, clients, and reading enquiries
- [ ] Blog/insights section for ongoing SEO
- [ ] Google Analytics behind a config flag

---

## 18. Acceptance checklist

**Content and business goals**
- [ ] All ten services are visible on the home page without scrolling past two screens on mobile
- [ ] "Supply, installation and maintenance" is stated in the hero
- [ ] Every service has its own detail page with unique copy
- [ ] Phone numbers are `tel:` links everywhere they appear
- [ ] Every page has at least one path to a quote request
- [ ] No invented statistics, client names, prices or certifications anywhere

**Technical**
- [ ] Six page types plus two detail-page types, each with its own controller and named route
- [ ] Route-model binding by slug on all detail pages
- [ ] All content comes from the database via seeders, not hardcoded in Blade
- [ ] Both forms validate, persist, and mail — with mail failure handled gracefully
- [ ] Rate limiting and honeypot active on both forms
- [ ] Custom 404 returns a 404 status

**SEO**
- [ ] Unique, correctly-lengthed title and meta description on every page
- [ ] One h1 per page, no skipped heading levels
- [ ] Canonical URL on every page
- [ ] Organization/LocalBusiness schema sitewide; Service, Product and BreadcrumbList schema where applicable; all validate
- [ ] `sitemap.xml` lists every public URL with accurate `lastmod`
- [ ] `robots.txt` present and references the sitemap
- [ ] Every image has meaningful alt text
- [ ] Footer links to all ten services from every page

**Design**
- [ ] Palette is grey, white and blue only — no other accent colour appears
- [ ] No item from the forbidden list in section 4.7 appears anywhere
- [ ] Left alignment throughout except the CTA band and 404
- [ ] Only one animated entrance on the site (home hero waveform)

**Accessibility and performance**
- [ ] Lighthouse mobile: Performance ≥ 90, Accessibility ≥ 95, Best Practices ≥ 95, SEO 100
- [ ] Keyboard-only navigation reaches and operates every interactive element with a visible focus ring
- [ ] No horizontal scroll at 360px on any page
- [ ] All text meets WCAG AA contrast
- [ ] `prefers-reduced-motion` disables all non-essential motion

---

## 19. Deployment

**Target:** Nginx + PHP-FPM 8.2 on a VPS, or cPanel shared hosting with the document root pointed at `public/`.

Steps:
1. Set `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://www.scartech.co.ke`, database credentials, SMTP credentials for `info@scartech.co.ke`.
2. `composer install --no-dev --optimize-autoloader`
3. `npm ci && npm run build`
4. `php artisan migrate --force && php artisan db:seed --force` (first deploy only)
5. `php artisan storage:link`
6. `php artisan optimize` (config, route, view caches)
7. Set directory permissions: `storage/` and `bootstrap/cache/` writable by the web user.
8. Install a TLS certificate; force HTTPS; 301 the non-canonical host.
9. Set long cache headers on `/build/` and `/images/`.
10. Point the domain, verify in Search Console, submit the sitemap.

**Post-launch, within the first week:**
- Submit to Google Search Console and Bing Webmaster Tools
- Create/claim the Google Business Profile for the Nairobi office with exactly the same name, address and phone as `config/company.php`
- Run Lighthouse on the live domain and fix any regressions
- Confirm both forms deliver mail to the real inbox from the live server

---

## 20. Open questions for the client

Collect answers before or during Phase 9. Do not guess.

1. Physical street address and building for the Nairobi HQ (needed for LocalBusiness schema, the map, and Google Business Profile).
2. Which client names and logos may be displayed publicly?
3. Are the stated brand partnerships current — specifically for CCTV, PA, and POS, which the profile does not list?
4. Does the company hold any fire-system certification or licensing that can be stated? If not, the fire page wording in 16.1 stands.
5. Social media profile URLs, if any.
6. Real product catalogue: models, categories, images, datasheets.
7. Preferred enquiry inbox and whether a WhatsApp business number should be used.
8. Business hours — confirm or correct the placeholder in `config/company.php`.
9. Company registration number and any certifications to display in the footer.
10. Is a blog/insights section wanted in a later phase?

---

*End of specification.*
