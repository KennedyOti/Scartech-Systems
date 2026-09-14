<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Seed the eight product categories Scartech supplies.
     */
    public function run(): void
    {
        $categories = [
            ['slug' => 'telephony-voip', 'name' => 'Telephony and VoIP', 'icon' => 'phone', 'description' => 'IP-PBX systems, desk and conference phones, expansion modules, SIP gateways and headsets for offices and contact centres.'],
            ['slug' => 'networking-fiber', 'name' => 'Networking and fiber', 'icon' => 'network', 'description' => 'Switches, routers, SFP modules, patch panels, cabinets, fiber cable and termination hardware, plus UPS units to keep network equipment powered.'],
            ['slug' => 'cctv-surveillance', 'name' => 'CCTV and surveillance', 'icon' => 'cctv', 'description' => 'IP and HD cameras, NVRs and DVRs, surveillance-rated hard drives, monitors and mounting accessories.'],
            ['slug' => 'access-control-biometrics', 'name' => 'Access control and biometrics', 'icon' => 'fingerprint', 'description' => 'Fingerprint, face and card readers, controllers, magnetic locks, exit buttons and time-and-attendance terminals.'],
            ['slug' => 'fire-safety', 'name' => 'Fire safety', 'icon' => 'flame', 'description' => 'Addressable and conventional fire alarm panels, smoke and heat detectors, sounders, strobes and manual call points.'],
            ['slug' => 'sound-av', 'name' => 'Sound and AV', 'icon' => 'speaker', 'description' => 'PA amplifiers and speakers, microphones, conference cameras and speakerphones, projectors and displays.'],
            ['slug' => 'pos-hardware', 'name' => 'POS hardware', 'icon' => 'receipt', 'description' => 'POS terminals, touch monitors, thermal receipt printers, barcode scanners and cash drawers.'],
            ['slug' => 'perimeter-security', 'name' => 'Perimeter security', 'icon' => 'zap', 'description' => 'Electric fence energisers, insulators, wire, brackets, sirens and razor wire for wall-top and freestanding perimeters.'],
        ];

        foreach ($categories as $index => $category) {
            ProductCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['sort_order' => $index + 1, 'is_active' => true],
            );
        }
    }
}
