<?php

return [
    'legal_name' => 'Scartech Systems Limited',
    'short_name' => 'Scartech Systems',
    'tagline' => 'Advisory, installation and maintenance for telecom and security systems',
    'positioning' => 'We are a leading service provider — advisory, installation and maintenance — in telecommunications and security systems. We are dedicated to providing professional, valuable and excellent services that meet our customers\' needs.',
    'values' => ['Innovation', 'Quality', 'Security', 'Excellence'],
    'email' => 'info@scartech.co.ke',
    'website' => 'https://www.scartech.co.ke',

    'whatsapp' => '254714801680', // digits only, for wa.me links

    'offices' => [
        [
            'country' => 'Kenya',
            'label' => 'Headquarters',
            'city' => 'Nairobi',
            'street' => '',            // CONFIRM WITH CLIENT — physical street address
            'phones' => ['+254 714 801 680', '+254 720 805 816', '+254 10 124 4120'],
            'is_primary' => true,
            'lat' => null,             // CONFIRM WITH CLIENT
            'lng' => null,
        ],
        [
            'country' => 'Uganda',
            'label' => 'Regional office',
            'city' => 'Kampala',
            'street' => '',
            'phones' => ['+256 689 7248'],
            'is_primary' => false,
        ],
        [
            'country' => 'Rwanda',
            'label' => 'Regional office',
            'city' => 'Kigali',
            'street' => '',
            'phones' => ['+250 85 71804'],
            'is_primary' => false,
        ],
    ],

    'expansion' => ['Tanzania', 'Burundi'],

    'areas_served' => ['Kenya', 'Uganda', 'Rwanda', 'Tanzania', 'Burundi'],

    'socials' => [
        // CONFIRM WITH CLIENT — omit any that don't exist rather than linking to a 404
        'linkedin' => null,
        'facebook' => null,
        'x' => null,
        'instagram' => null,
    ],

    'hours' => [
        'weekday' => '08:00–17:30',
        'saturday' => '09:00–13:00',
        'sunday' => 'Closed',
        'support' => '24/7 for clients on an SLA',
    ],

    /*
    | Product categories shown as related products on each service detail page.
    */
    'service_product_categories' => [
        'it-solutions' => ['networking-fiber'],
        'cctv-installation' => ['cctv-surveillance'],
        'data-voice-solutions' => ['telephony-voip', 'networking-fiber'],
        'sound-pa-solutions' => ['sound-av'],
        'event-management' => ['sound-av'],
        'fire-system' => ['fire-safety'],
        'electric-fence' => ['perimeter-security'],
        'pos-systems' => ['pos-hardware'],
        'access-control-systems' => ['access-control-biometrics'],
        'fiber-installation' => ['networking-fiber'],
    ],

    /*
    | Technology partner logos. Width and height are the artwork's intrinsic
    | dimensions, used to size every logo to the same visual weight. The
    | optional scale compensates for artwork that reads light (thin type).
    */
    'partners' => [
        ['name' => 'Cisco', 'logo' => 'images/partners/cisco.svg', 'width' => 216, 'height' => 114],
        ['name' => 'Avaya', 'logo' => 'images/partners/avaya.svg', 'width' => 350, 'height' => 100],
        ['name' => 'Grandstream', 'logo' => 'images/partners/grandstream.svg', 'width' => 595, 'height' => 234, 'scale' => 1.4],
        ['name' => 'Microsoft', 'logo' => 'images/partners/microsoft.svg', 'width' => 338, 'height' => 72],
        ['name' => 'Polycom', 'logo' => 'images/partners/polycom.svg', 'width' => 152, 'height' => 40],
        ['name' => 'Yealink', 'logo' => 'images/partners/yealink.png', 'width' => 1080, 'height' => 228],
        ['name' => 'Digium', 'logo' => 'images/partners/digium.png', 'width' => 317, 'height' => 172],
        ['name' => 'D-Link', 'logo' => 'images/partners/d-link.svg', 'width' => 800, 'height' => 161],
        ['name' => 'NEC', 'logo' => 'images/partners/nec.svg', 'width' => 302, 'height' => 82],
        ['name' => 'Panasonic', 'logo' => 'images/partners/panasonic.svg', 'width' => 504, 'height' => 80],
        ['name' => 'LG Ericsson (iPECS)', 'logo' => 'images/partners/lg-ericsson-ipecs.svg', 'width' => 121, 'height' => 45, 'scale' => 1.25],
        ['name' => 'Hikvision', 'logo' => 'images/partners/hikvision.svg', 'width' => 159, 'height' => 22], // CONFIRM WITH CLIENT
    ],
];
