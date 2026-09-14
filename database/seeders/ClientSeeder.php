<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Seed the clients shown on the portfolio page.
     *
     * Only clients who have given written permission for their name and logo to be displayed on the home and
     * about pages may be seeded with is_featured = true. Clients without a logo file render as a name tile.
     */
    public function run(): void
    {
        foreach ($this->clients() as $index => $client) {
            Client::updateOrCreate(
                ['name' => $client['name']],
                $client + ['logo' => null, 'logo_width' => null, 'logo_height' => null, 'is_featured' => false, 'sort_order' => $index + 1],
            );
        }
    }

    /**
     * @return list<array{name: string, sector: string, logo?: string, logo_width?: int, logo_height?: int}>
     */
    private function clients(): array
    {
        return [
            ['name' => 'Penda Health', 'sector' => 'Healthcare', 'logo' => 'images/clients/penda-health.png', 'logo_width' => 640, 'logo_height' => 178],
            // Logo pending: only a low-resolution copy of Faulu's retired logo is available publicly.
            ['name' => 'Faulu Microfinance Bank', 'sector' => 'Financial services'],
            ['name' => 'Domino\'s Pizza', 'sector' => 'Hospitality', 'logo' => 'images/clients/dominos-pizza.png', 'logo_width' => 640, 'logo_height' => 640],
            ['name' => 'Cold Stone Creamery', 'sector' => 'Hospitality', 'logo' => 'images/clients/cold-stone-creamery.png', 'logo_width' => 421, 'logo_height' => 91],
            ['name' => 'ED Partners Africa', 'sector' => 'Education', 'logo' => 'images/clients/ed-partners-africa.png', 'logo_width' => 640, 'logo_height' => 173],
            ['name' => 'Kenya Space Agency', 'sector' => 'Government', 'logo' => 'images/clients/kenya-space-agency.png', 'logo_width' => 210, 'logo_height' => 166],
            ['name' => 'Telespazio', 'sector' => 'Aerospace', 'logo' => 'images/clients/telespazio.png', 'logo_width' => 640, 'logo_height' => 110],
            // Name tile only: use of the U.S. Great Seal and Department of State seal is legally restricted.
            ['name' => 'U.S. Embassy Nairobi', 'sector' => 'Diplomatic'],
            ['name' => 'Marriott Hotels', 'sector' => 'Hospitality', 'logo' => 'images/clients/marriott-hotels.png', 'logo_width' => 640, 'logo_height' => 316],
            ['name' => 'Nairobi City Water and Sewerage Company', 'sector' => 'Utilities', 'logo' => 'images/clients/nairobi-water.png', 'logo_width' => 76, 'logo_height' => 115],
            ['name' => 'Two Rivers Mall', 'sector' => 'Retail', 'logo' => 'images/clients/two-rivers-mall.png', 'logo_width' => 541, 'logo_height' => 640],
            ['name' => 'Nairobi City County', 'sector' => 'Government', 'logo' => 'images/clients/nairobi-city-county.png', 'logo_width' => 261, 'logo_height' => 87],
            // Logo pending: no published logo found.
            ['name' => 'Jojes Oil Dealers', 'sector' => 'Energy'],
            ['name' => 'Mövenpick Hotel Kigali', 'sector' => 'Hospitality', 'logo' => 'images/clients/movenpick-hotels.png', 'logo_width' => 640, 'logo_height' => 206],
            ['name' => 'Optica', 'sector' => 'Retail', 'logo' => 'images/clients/optica.png', 'logo_width' => 205, 'logo_height' => 83],
            ['name' => 'Kenya Police Service', 'sector' => 'Government', 'logo' => 'images/clients/kenya-police-service.png', 'logo_width' => 263, 'logo_height' => 220],
            ['name' => 'Isuzu East Africa', 'sector' => 'Automotive', 'logo' => 'images/clients/isuzu-east-africa.png', 'logo_width' => 640, 'logo_height' => 112],
            ['name' => 'Takaful Insurance of Africa', 'sector' => 'Financial services', 'logo' => 'images/clients/takaful-insurance-of-africa.png', 'logo_width' => 640, 'logo_height' => 221],
            ['name' => 'Dawa Life Sciences', 'sector' => 'Healthcare', 'logo' => 'images/clients/dawa-life-sciences.png', 'logo_width' => 640, 'logo_height' => 640],
            ['name' => 'Abacus Pharma', 'sector' => 'Healthcare', 'logo' => 'images/clients/abacus-pharma.png', 'logo_width' => 375, 'logo_height' => 126],
        ];
    }
}
