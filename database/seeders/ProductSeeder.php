<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed products.
     *
     * The active records are built from the product photographs supplied by the client. Specifications
     * only list what is visible on the product or its packaging. Confirm stock lines with the client.
     */
    public function run(): void
    {
        $categoryIds = ProductCategory::pluck('id', 'slug');

        foreach ($this->products() as $index => $product) {
            $categorySlug = $product['category'];
            unset($product['category']);

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product + [
                    'product_category_id' => $categoryIds[$categorySlug],
                    'sort_order' => $index + 1,
                    'gallery' => $product['gallery'] ?? [],
                    'is_featured' => $product['is_featured'] ?? false,
                ],
            );
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function products(): array
    {
        return [
            [
                'category' => 'cctv-surveillance',
                'name' => 'Hikvision 2 MP fixed IR mini bullet network camera',
                'slug' => 'hikvision-2mp-mini-bullet-camera',
                'brand' => 'Hikvision',
                'model_number' => null,
                'summary' => 'A compact outdoor IP bullet camera with infrared night vision, suited to entrances, parking areas and building perimeters.',
                'description' => '<p>A fixed-lens network camera for general-purpose surveillance. We supply it as part of a complete CCTV installation, mounted, focused and connected to your recorder, or as a replacement unit for an existing Hikvision system.</p>',
                'specifications' => [
                    ['label' => 'Camera type', 'value' => 'Fixed mini bullet, IP network'],
                    ['label' => 'Resolution', 'value' => '2 MP HD video'],
                    ['label' => 'Night vision', 'value' => 'EXIR infrared'],
                    ['label' => 'Housing', 'value' => 'Water-proof, wall mount bracket'],
                ],
                'features' => ['HD video over the network', 'EXIR infrared for low-light and night recording', 'Weatherproof housing for outdoor mounting', 'Works with Hikvision NVRs and remote viewing apps'],
                'image' => 'images/products/hikvision-2mp-mini-bullet-camera.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category' => 'cctv-surveillance',
                'name' => 'Seagate SkyHawk 4 TB surveillance hard drive',
                'slug' => 'seagate-skyhawk-4tb-surveillance-hdd',
                'brand' => 'Seagate',
                'model_number' => 'ST4000VX007',
                'summary' => 'A hard drive built for continuous video recording in NVRs and DVRs, used when sizing storage for your retention period.',
                'description' => '<p>Surveillance recorders write video around the clock, which wears out desktop drives quickly. SkyHawk drives are designed for that workload. We size the number of drives to the cameras and the number of days of footage you need to keep.</p>',
                'specifications' => [
                    ['label' => 'Capacity', 'value' => '4 TB'],
                    ['label' => 'Product line', 'value' => 'SkyHawk Surveillance'],
                    ['label' => 'Model', 'value' => 'ST4000VX007'],
                    ['label' => 'Use', 'value' => 'NVR and DVR recorders'],
                ],
                'features' => ['Designed for 24/7 video recording', 'Fits standard NVR and DVR drive bays', 'Installed and formatted as part of recorder setup'],
                'image' => 'images/products/seagate-skyhawk-4tb-surveillance-hdd.jpg',
                'is_active' => true,
            ],
            [
                'category' => 'access-control-biometrics',
                'name' => 'Matrix fingerprint access control readers',
                'slug' => 'matrix-biometric-access-readers',
                'brand' => 'Matrix',
                'model_number' => null,
                'summary' => 'Door readers that verify staff by fingerprint or card, with a keypad-and-display terminal for time and attendance.',
                'description' => '<p>A slim fingerprint reader for doors and a terminal model with a keypad and display for clock-in points. We install them with locks, exit buttons and controllers, and connect them to management software so access rules and attendance reports are handled centrally.</p>',
                'specifications' => [
                    ['label' => 'Credentials', 'value' => 'Fingerprint and proximity card'],
                    ['label' => 'Terminal model', 'value' => 'Keypad and display'],
                    ['label' => 'Mounting', 'value' => 'Wall or door frame'],
                ],
                'features' => ['Fingerprint verification at the door', 'Card reading on the same unit', 'Attendance records for payroll', 'Status LED for users'],
                'image' => 'images/products/matrix-biometric-access-readers.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category' => 'telephony-voip',
                'name' => 'Yealink colour-screen expansion module',
                'slug' => 'yealink-colour-expansion-module',
                'brand' => 'Yealink',
                'model_number' => null,
                'summary' => 'An add-on key module for Yealink IP phones, giving receptionists and operators more programmable line and speed-dial keys.',
                'description' => '<p>Reception desks and operator positions need to see and transfer to many extensions at once. The expansion module attaches to a compatible Yealink desk phone and is configured with your extension plan when we set up the IP-PBX.</p>',
                'specifications' => [
                    ['label' => 'Display', 'value' => 'Colour LCD'],
                    ['label' => 'Keys', 'value' => '20 programmable keys per page'],
                    ['label' => 'Pages', 'value' => '3 page keys'],
                ],
                'features' => ['Busy-lamp field for colleague extensions', 'Speed dial and call transfer keys', 'Configured with your extension plan'],
                'image' => 'images/products/yealink-colour-expansion-module.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category' => 'sound-av',
                'name' => 'Logitech video conferencing kit',
                'slug' => 'logitech-group-conference-camera',
                'brand' => 'Logitech',
                'model_number' => null,
                'summary' => 'A pan-tilt-zoom conference camera with a speakerphone, hub and remote, for meeting rooms of up to medium size.',
                'description' => '<p>A plug-in video conferencing set for boardrooms and meeting rooms. We mount the camera, position the speakerphone, run the cabling to the room display and test it with Microsoft Teams or your preferred platform.</p>',
                'specifications' => [
                    ['label' => 'Camera', 'value' => 'Pan, tilt and zoom'],
                    ['label' => 'Audio', 'value' => 'Speakerphone with dial pad'],
                    ['label' => 'Included', 'value' => 'Camera, speakerphone, hub, remote'],
                ],
                'features' => ['Remote control for camera positioning', 'Speakerphone with call controls', 'Works with common meeting platforms', 'Installed and tested in your room'],
                'image' => 'images/products/logitech-group-conference-camera.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category' => 'sound-av',
                'name' => 'Epson 3LCD business projector',
                'slug' => 'epson-3lcd-business-projector',
                'brand' => 'Epson',
                'model_number' => null,
                'summary' => 'A portable projector for classrooms, training rooms and meeting spaces.',
                'description' => '<p>Suited to classrooms and training rooms. We supply ceiling or table mounting, run the display cabling and connect it to the room audio where required.</p>',
                'specifications' => [
                    ['label' => 'Technology', 'value' => '3LCD'],
                    ['label' => 'Form', 'value' => 'Portable, ceiling mount option'],
                ],
                'features' => ['3LCD projection', 'Ceiling or table installation', 'Cabling and audio connection on request'],
                'image' => 'images/products/epson-3lcd-business-projector.jpg',
                'is_active' => true,
            ],
            [
                'category' => 'networking-fiber',
                'name' => 'Gigabit copper SFP module (RJ45)',
                'slug' => 'gigabit-copper-sfp-module',
                'brand' => null,
                'model_number' => null,
                'summary' => 'A transceiver that adds a copper RJ45 gigabit port to a switch or router SFP slot.',
                'description' => '<p>Used when a switch has spare SFP slots but the link needs copper cabling. We check compatibility with your switch model before supply.</p>',
                'specifications' => [
                    ['label' => 'Form factor', 'value' => 'SFP'],
                    ['label' => 'Connector', 'value' => 'RJ45 copper'],
                    ['label' => 'Speed', 'value' => 'Gigabit Ethernet'],
                ],
                'features' => ['Hot-swappable', 'Compatibility checked against your switch'],
                'image' => 'images/products/gigabit-copper-sfp-module.jpg',
                'is_active' => true,
            ],
            [
                'category' => 'networking-fiber',
                'name' => 'Tripp Lite line-interactive UPS',
                'slug' => 'tripp-lite-line-interactive-ups',
                'brand' => 'Tripp Lite',
                'model_number' => null,
                'summary' => 'A tower UPS with LCD status display to keep network, CCTV and phone equipment running through power cuts.',
                'description' => '<p>Power cuts and surges are the most common cause of damaged network and recording equipment. We size UPS units to the load and the runtime you need, and install them in cabinets and at recorder positions.</p>',
                'specifications' => [
                    ['label' => 'Form', 'value' => 'Tower'],
                    ['label' => 'Display', 'value' => 'LCD status display'],
                ],
                'features' => ['Battery backup during outages', 'Protects switches, NVRs and PBX equipment', 'Sized to your load and runtime'],
                'image' => 'images/products/tripp-lite-line-interactive-ups.jpg',
                'is_active' => true,
            ],

            // TEMPLATE — replace with real catalogue data. Inactive until confirmed.
            [
                'category' => 'fire-safety',
                'name' => 'Addressable fire alarm panel',
                'slug' => 'addressable-fire-alarm-panel',
                'brand' => null,
                'model_number' => null,
                'summary' => 'Template record. Replace with a confirmed fire alarm panel from the catalogue.',
                'description' => null,
                'specifications' => [],
                'features' => [],
                'image' => null,
                'is_active' => false,
            ],
            // TEMPLATE — replace with real catalogue data. Inactive until confirmed.
            [
                'category' => 'pos-hardware',
                'name' => 'POS terminal',
                'slug' => 'pos-terminal',
                'brand' => null,
                'model_number' => null,
                'summary' => 'Template record. Replace with a confirmed POS terminal from the catalogue.',
                'description' => null,
                'specifications' => [],
                'features' => [],
                'image' => null,
                'is_active' => false,
            ],
            // TEMPLATE — replace with real catalogue data. Inactive until confirmed.
            [
                'category' => 'perimeter-security',
                'name' => 'Electric fence energiser',
                'slug' => 'electric-fence-energiser',
                'brand' => null,
                'model_number' => null,
                'summary' => 'Template record. Replace with a confirmed energiser from the catalogue.',
                'description' => null,
                'specifications' => [],
                'features' => [],
                'image' => null,
                'is_active' => false,
            ],
        ];
    }
}
