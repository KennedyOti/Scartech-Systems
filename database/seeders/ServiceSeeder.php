<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed the ten Scartech services in their published order.
     */
    public function run(): void
    {
        foreach ($this->services() as $index => $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service + ['sort_order' => $index + 1, 'is_active' => true],
            );
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function services(): array
    {
        return [
            [
                'name' => 'IT solutions',
                'slug' => 'it-solutions',
                'icon' => 'server-cog',
                'tagline' => 'Networks, servers and cloud that stay up.',
                'summary' => 'We design, supply and support the IT backbone your business runs on — from structured networks and switching to servers, Microsoft 365 and day-to-day support. One team handles the design, the hardware and the maintenance.',
                'meta_title' => 'IT support and solutions in Nairobi',
                'meta_description' => 'IT support in Nairobi from Scartech Systems: network design, servers, Microsoft 365, firewalls and SLA-backed support for offices, schools and banks.',
                'body' => '<p>When the network is slow or a server goes down, work stops. Most organisations do not need more technology, they need the technology they already rely on to be designed properly and looked after. That is the gap our IT support in Nairobi and across the region fills.</p>'
                    .'<p>We start with a survey of what you have and what you need, then design the network, specify the hardware, supply it from our vendor partners and install it. Switches are configured, VLANs segmented, servers built, backups scheduled and Microsoft 365 migrated before we hand over. After go-live the same engineers stay on as your support team.</p>'
                    .'<p>Every installation is documented: network diagrams, IP plans, credentials handed over securely, and a support agreement with response times written down, not implied.</p>',
                'capabilities' => [
                    ['title' => 'Network design and switching', 'description' => 'Layer 2 and Layer 3 topologies, VLAN segmentation, routing and bandwidth prioritisation for offices, campuses and multi-site businesses.'],
                    ['title' => 'Servers and storage', 'description' => 'Specification, supply, installation and configuration of on-premise servers, NAS and backup hardware.'],
                    ['title' => 'Microsoft 365 and cloud', 'description' => 'Email migration, Exchange, SharePoint, OneDrive and Teams deployment with data protection policies.'],
                    ['title' => 'Endpoint and network security', 'description' => 'Firewall deployment, access policies, patching and backup routines.'],
                    ['title' => 'IT support and SLA', 'description' => 'Remote and on-site support with response times agreed up front.'],
                ],
                'deliverables' => ['Network design and IP plan', 'Supplied and configured hardware', 'As-built documentation', 'Support agreement with defined response times'],
                'applications' => ['Corporate offices', 'Universities and schools', 'Banks and SACCOs', 'Hospitals', 'Multi-branch retail'],
                'brands' => ['Cisco', 'D-Link', 'Microsoft', 'HP', 'Dell'],
                'hero_image' => 'images/services/it-solutions.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'CCTV installation',
                'slug' => 'cctv-installation',
                'icon' => 'cctv',
                'tagline' => 'See every corner, day and night, from anywhere.',
                'summary' => 'High-definition IP surveillance from a single-building camera set to a multi-site system with a staffed control room. We survey the site, engineer the coverage, install and commission it, then keep it running.',
                'meta_title' => 'CCTV installation in Kenya',
                'meta_description' => 'CCTV installation in Kenya by Scartech Systems: site survey, HD IP cameras, NVR recording, control rooms, remote viewing and preventive maintenance.',
                'body' => '<p>A camera system is only useful if it records the right thing, clearly, when it matters. Poorly placed cameras, undersized storage and systems nobody maintains are the reasons most footage fails when it is finally needed. Our CCTV installation in Kenya is built around avoiding exactly that.</p>'
                    .'<p>We walk the site first, mapping sightlines, lighting and the assets you need covered. From that survey we design camera positions and recording capacity, supply the cameras and recorders, run and terminate the cabling, mount and focus every camera, and configure remote viewing on your phones and laptops. Your team is trained on playback and export before we leave.</p>'
                    .'<p>After handover we offer scheduled preventive maintenance: lens cleaning, focus checks, firmware updates and storage health reports, so the system still works a year later.</p>',
                'capabilities' => [
                    ['title' => 'Site survey and coverage design', 'description' => 'Camera placement planned around actual sightlines, lighting and the assets you need covered.'],
                    ['title' => 'IP and HD camera installation', 'description' => 'Fixed, PTZ, dome and bullet cameras with night vision and weatherproofing for external runs.'],
                    ['title' => 'Recording and storage', 'description' => 'NVR and DVR sizing for your required retention period, with RAID and off-site backup options.'],
                    ['title' => 'Control rooms and video walls', 'description' => 'Multi-screen monitoring stations for security teams.'],
                    ['title' => 'Remote access', 'description' => 'Secure viewing from phone, tablet or laptop.'],
                    ['title' => 'Preventive maintenance', 'description' => 'Scheduled cleaning, focus checks, firmware updates and storage health reports.'],
                ],
                'deliverables' => ['Coverage plan with camera positions', 'Commissioned cameras and recorders', 'Remote viewing set up on your devices', 'Operator training and maintenance schedule'],
                'applications' => ['Corporate offices', 'Retail and shopping complexes', 'Schools and universities', 'Warehouses and yards', 'Residential estates'],
                // CONFIRM WITH CLIENT — CCTV brand partnerships are not listed in the profile.
                'brands' => ['Hikvision', 'Dahua'],
                'hero_image' => 'images/services/cctv-installation.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Data and voice solutions',
                'slug' => 'data-voice-solutions',
                'icon' => 'network',
                'tagline' => 'Structured cabling and IP telephony, certified and documented.',
                'summary' => 'The cabling and phone system that everything else depends on. We install certified structured cabling and data/voice cabinets, then deploy IP-PBX telephony over the same network — IVR, call recording, voicemail to email and CRM integration included.',
                'meta_title' => 'Structured cabling and VoIP in Nairobi',
                'meta_description' => 'Structured cabling in Nairobi and VoIP phone systems in Kenya: Cat6/Cat6A to TIA/EIA-568-C, Fluke-certified tests, data cabinets and IP-PBX telephony.',
                'body' => '<p>Every device in a building, from desk phones to cameras to Wi-Fi access points, depends on the cabling behind the walls. Structured cabling done badly shows up later as dropped calls, slow links and cabinets nobody can trace. We install structured cabling in Nairobi and across East Africa so that it never becomes the problem.</p>'
                    .'<p>Our engineers survey the building, design cable routes and cabinet positions, supply the copper, patch panels and racks, then install, terminate and label every point. Each link is tested with a Fluke certifier. On top of that network we deploy VoIP phone systems: IP-PBX, extensions, IVR menus, call recording and SIP trunks from your provider.</p>'
                    .'<p>You receive test reports for every cable, a labelled floor plan and a documented extension plan, so your team or ours can maintain it for years.</p>',
                'capabilities' => [
                    ['title' => 'Structured cabling', 'description' => 'Cat6/Cat6A copper installed to TIA/EIA-568-C, with Fluke-certified test reports, labelling and cable tray management.'],
                    ['title' => 'Data and voice cabinets', 'description' => 'Rack build, MDF termination, patch panel layout and high-density patching.'],
                    ['title' => 'IP-PBX and VoIP', 'description' => 'On-premise or hosted phone systems with extensions across offices and remote staff.'],
                    ['title' => 'SIP trunking', 'description' => 'Connect to your provider and cut line costs.'],
                    ['title' => 'Call features', 'description' => 'IVR menus, call queuing and routing, voicemail to email, automated call recording.'],
                    ['title' => 'CRM and mobility integration', 'description' => 'Desk phones, softphones and mobile apps on one extension plan.'],
                ],
                'deliverables' => ['Fluke certification report for every link', 'Labelled cabinets and floor plan', 'Configured IP-PBX and extension plan', 'User and administrator training'],
                'applications' => ['Contact centres', 'Corporate head offices', 'Hotels', 'Hospitals', 'Campuses'],
                'brands' => ['Cisco', 'Avaya', 'Yealink', 'Grandstream', 'Panasonic', 'NEC', 'Digium', 'LG Ericsson (iPECS)'],
                'hero_image' => 'images/services/data-voice-solutions.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Sound and PA solutions',
                'slug' => 'sound-pa-solutions',
                'icon' => 'speaker',
                'tagline' => 'Announcements, paging and background audio that carry.',
                'summary' => 'Public address and sound reinforcement designed for the room and the building — zoned paging, background music, evacuation announcements and boardroom audio, installed and tuned on site.',
                'meta_title' => 'PA system installation in Kenya',
                'meta_description' => 'PA system installation in Kenya: zoned paging, evacuation announcements, boardroom and conference audio, and background music, installed and tuned on site.',
                'body' => '<p>An announcement nobody can make out is worse than none at all. Good public address depends on the building: ceiling heights, hard surfaces, outdoor areas and noise. Our PA system installation in Kenya starts with the space, not a catalogue.</p>'
                    .'<p>We survey the rooms and grounds, design the zones and speaker layout, and size the amplifiers. We then supply and install the speakers, microphones, mixers and paging stations, run the cabling, and tune levels in each zone on site until speech is clear and music sits at the right volume. Where a fire system exists, we integrate voice evacuation so announcements follow the alarm.</p>'
                    .'<p>Handover includes a zone map, operator training for reception or security staff, and a maintenance visit schedule.</p>',
                'capabilities' => [
                    ['title' => 'Zoned PA systems', 'description' => 'Independent audio zones for floors, wings or outdoor areas with central paging.'],
                    ['title' => 'Evacuation and emergency announcement', 'description' => 'Voice alarm integration with the fire system.'],
                    ['title' => 'Conference and boardroom audio', 'description' => 'Ceiling and table microphones, DSP mixing, amplifiers and speaker layout.'],
                    ['title' => 'Background music distribution', 'description' => 'For retail floors, restaurants, lobbies and waiting areas.'],
                    ['title' => 'School and campus systems', 'description' => 'Bell scheduling, assembly and field coverage.'],
                    ['title' => 'Tuning and commissioning', 'description' => 'On-site level balancing and coverage testing.'],
                ],
                'deliverables' => ['Zone and speaker layout', 'Installed and tuned audio system', 'Operator training', 'Maintenance schedule'],
                'applications' => ['Schools and universities', 'Houses of worship', 'Shopping malls', 'Factories and warehouses', 'Hotels and conference centres'],
                // CONFIRM WITH CLIENT — PA brand partnerships are not listed in the profile.
                'brands' => [],
                'hero_image' => 'images/services/sound-pa-solutions.jpg',
            ],
            [
                'name' => 'Event management',
                'slug' => 'event-management',
                'icon' => 'calendar-check',
                'tagline' => "Sound, screens and connectivity for events that can't fail.",
                'summary' => 'Technical production for conferences, launches, AGMs and functions — PA and sound, LED screens and projection, delegate microphone systems, event Wi-Fi and live streaming, with a crew on site throughout.',
                'meta_title' => 'Event sound, screens and streaming in Kenya',
                'meta_description' => 'Event technical production in Kenya: PA and sound, LED screens and projection, delegate microphones, event Wi-Fi and live streaming with an on-site crew.',
                'body' => '<p>At a conference or AGM there is no second take. If the microphones feed back, the slides do not show or the stream drops, the audience notices immediately. We provide the technical side of events so the organisers can focus on the programme.</p>'
                    .'<p>We visit the venue beforehand, plan the sound, screen and network layout against the run of show, and bring the equipment and crew. Our team sets up the PA, screens and projectors, delegate microphones and temporary Wi-Fi, rehearses with your speakers, operates everything live and clears the venue afterwards.</p>'
                    .'<p>Because we install permanent telecom and AV systems as our day job, the event network and streaming are engineered with the same care: backup links, spare microphones and a technician at every critical position.</p>',
                'capabilities' => [
                    ['title' => 'Sound and PA for events', 'description' => 'Line arrays, stage monitoring, wireless microphones and mixing.'],
                    ['title' => 'Screens and projection', 'description' => 'LED walls, projectors and confidence monitors.'],
                    ['title' => 'Conference and delegate systems', 'description' => 'Chairman and delegate microphone units with voting and interpretation options.'],
                    ['title' => 'Event connectivity', 'description' => 'Temporary high-density Wi-Fi and wired uplinks for registration and streaming.'],
                    ['title' => 'Live streaming and recording', 'description' => 'Multi-camera capture and streaming to your platform.'],
                    ['title' => 'On-site technical crew', 'description' => 'Setup, rehearsal, live operation and strike.'],
                ],
                'deliverables' => ['Venue technical plan', 'Equipment supply and setup', 'Live operation by our crew', 'Event recording on request'],
                'applications' => ['Corporate conferences', 'AGMs', 'Product launches', 'Graduations', 'Government and NGO forums'],
                'brands' => [],
                'hero_image' => null,
            ],
            [
                'name' => 'Fire systems',
                'slug' => 'fire-system',
                'icon' => 'flame',
                'tagline' => 'Detection, alarm and evacuation, installed to standard.',
                'summary' => 'Addressable and conventional fire detection and alarm systems — panels, detectors, sounders and call points — installed, commissioned and documented, with integration to access control so doors release safely.',
                'meta_title' => 'Fire alarm system installation in Nairobi',
                'meta_description' => 'Fire alarm system installation in Nairobi: addressable and conventional panels, detectors, sounders and call points, commissioned and documented.',
                'body' => '<p>A fire alarm has one job: detect early and get people out. That depends on the right detectors in the right places, a panel that tells you exactly where the alarm came from, and doors that release when they should. Our fire alarm system installation in Nairobi and beyond is built around those three things.</p>'
                    .'<p>We survey the building layout and usage, design the detection zones and device positions, and supply the panel, detectors, sounders, strobes and call points. Our engineers install and wire the system, interlock it with access control and PA where present, and run a full cause-and-effect test before handover.</p>'
                    .'<p>You receive as-built drawings and test records for your inspection, plus a maintenance plan covering device testing, battery checks and panel servicing.</p>'
                    // CONFIRM WITH CLIENT — do not claim regulatory certification the company does not hold.
                    .'<p>We install and maintain detection and alarm systems. Where a project requires certification or suppression works falling under a licensed contractor, we coordinate with the appropriate specialists.</p>',
                'capabilities' => [
                    ['title' => 'Fire alarm panels', 'description' => 'Addressable and conventional systems sized to the building and its zones.'],
                    ['title' => 'Detection devices', 'description' => 'Smoke, heat, multi-sensor and beam detectors positioned to the building layout.'],
                    ['title' => 'Alarm and notification', 'description' => 'Sounders, strobes, manual call points and voice evacuation integration.'],
                    ['title' => 'Access control interlock', 'description' => 'Automatic fail-safe door release on alarm.'],
                    ['title' => 'Commissioning and documentation', 'description' => 'Full cause-and-effect testing with as-built documentation for your inspection.'],
                    ['title' => 'Maintenance and testing', 'description' => 'Scheduled device testing, battery checks and panel servicing.'],
                ],
                'deliverables' => ['Detection zone layout', 'Commissioned panel and devices', 'Cause-and-effect test records', 'As-built drawings and maintenance plan'],
                'applications' => ['Office towers', 'Hotels', 'Schools', 'Hospitals', 'Warehouses and industrial plants'],
                'brands' => [],
                'hero_image' => null,
            ],
            [
                'name' => 'Electric fence',
                'slug' => 'electric-fence',
                'icon' => 'zap',
                'tagline' => 'A perimeter that reacts before anyone reaches the building.',
                'summary' => 'Perimeter electric fencing designed, supplied and installed — wall-top or freestanding, zoned, with energisers, alarm integration and a maintenance plan.',
                'meta_title' => 'Electric fence installation in Kenya',
                'meta_description' => 'Electric fence installation in Kenya: wall-top and freestanding perimeter fencing, zoned energisers, alarm and CCTV integration, and maintenance.',
                'body' => '<p>The best time to stop an intruder is at the boundary. A properly installed electric fence deters, detects and tells you precisely where someone tried to cross. Our electric fence installation in Kenya covers homes, estates, schools and commercial yards.</p>'
                    .'<p>We measure the perimeter, check walls and ground conditions, and split the fence into monitored zones. We supply brackets, insulators, wire and energisers, install and tension the fence, integrate gates and razor wire into a continuous perimeter, and connect alarms, sirens and phone notification. Where CCTV exists, we link the zones so cameras show the alarm location.</p>'
                    .'<p>Fences degrade with vegetation and weather, so every installation comes with a maintenance option: voltage testing, clearance, insulator replacement and fault tracing.</p>',
                'capabilities' => [
                    ['title' => 'Perimeter design and zoning', 'description' => 'The fence split into monitored zones so an alarm tells you exactly where the breach is.'],
                    ['title' => 'Wall-top and freestanding installation', 'description' => 'Brackets, insulators, wires and tensioning for masonry walls or standalone posts.'],
                    ['title' => 'Energisers and control', 'description' => 'Mains and solar-backed energisers with keypad control and voltage monitoring.'],
                    ['title' => 'Alarm and monitoring integration', 'description' => 'Siren, strobe, control room and phone notification, linked to CCTV where installed.'],
                    ['title' => 'Gate and razor wire integration', 'description' => 'Continuous perimeter including gates and vehicle entries.'],
                    ['title' => 'Maintenance', 'description' => 'Vegetation clearance, voltage testing, insulator replacement and fault tracing.'],
                ],
                'deliverables' => ['Perimeter zone plan', 'Installed and energised fence', 'Alarm and notification setup', 'Maintenance schedule'],
                'applications' => ['Residential estates', 'Warehouses and yards', 'Schools', 'Factories', 'Farms and depots'],
                'brands' => [],
                'hero_image' => null,
            ],
            [
                'name' => 'POS systems',
                'slug' => 'pos-systems',
                'icon' => 'receipt',
                'tagline' => 'Tills, stock and reporting that agree with each other.',
                'summary' => 'Point-of-sale hardware and software for retail and hospitality — terminals, printers, scanners and cash drawers, set up with inventory control and multi-branch reporting, then supported.',
                'meta_title' => 'POS systems in Kenya',
                'meta_description' => 'POS systems in Kenya for retail and hospitality: terminals, receipt printers, scanners, inventory control and multi-branch reporting, installed and supported.',
                'body' => '<p>When the tills, the stock count and the accounts disagree, money leaks. A point-of-sale system that is set up correctly gives you sales, stock and shift figures you can trust from every branch. We supply and install POS systems in Kenya for shops, restaurants, hotels and pharmacies.</p>'
                    .'<p>We look at how you sell today, then specify the terminals, printers, scanners and cash drawers, and configure the software with your products, prices, tax settings and user roles. We network the tills, connect branches for consolidated reporting, link payment terminals and accounting where needed, and train cashiers and supervisors at handover.</p>'
                    .'<p>After go-live we support the hardware and software, help with stock-takes and adjust the setup as your product list or branches grow.</p>',
                'capabilities' => [
                    ['title' => 'POS hardware supply', 'description' => 'Terminals, touch monitors, thermal receipt printers, barcode scanners and cash drawers.'],
                    ['title' => 'Retail and hospitality software', 'description' => 'Configured for your products, prices, tax and shift patterns.'],
                    ['title' => 'Inventory and stock control', 'description' => 'Stock levels, reorder points and stock-take support across branches.'],
                    ['title' => 'Multi-branch reporting', 'description' => 'Consolidated sales, margin and shift reports from every till.'],
                    ['title' => 'Integration', 'description' => 'Links to accounting, CRM and payment terminals.'],
                    ['title' => 'Staff training and support', 'description' => 'Till training at handover plus ongoing support.'],
                ],
                'deliverables' => ['Configured tills and peripherals', 'Product and price setup', 'Branch reporting', 'Cashier and supervisor training'],
                'applications' => ['Supermarkets and retail chains', 'Restaurants and cafés', 'Hotels', 'Pharmacies', 'Hardware and distribution'],
                // CONFIRM WITH CLIENT — POS brands are not listed in the profile.
                'brands' => [],
                'hero_image' => null,
            ],
            [
                'name' => 'Access control systems',
                'slug' => 'access-control-systems',
                'icon' => 'scan-face',
                'tagline' => 'Know who goes where, and when.',
                'summary' => 'Biometric and card-based access control with time and attendance — fingerprint, facial recognition, RFID and turnstiles, centrally managed and integrated with your fire and CCTV systems.',
                'meta_title' => 'Access control systems in Nairobi',
                'meta_description' => 'Access control systems in Nairobi: fingerprint, face and card readers, magnetic locks, turnstiles, time and attendance, integrated with fire and CCTV.',
                'body' => '<p>Keys get copied and visitor books get ignored. Access control replaces both with a record of who opened which door and when, and the ability to revoke access instantly. We install access control systems in Nairobi and across the region for offices, banks, server rooms and campuses.</p>'
                    .'<p>We survey each entry point, agree the access rules with you, and specify readers, locks and controllers suited to the door and its traffic. Our engineers install the hardware, wire it to fail-safe power, interlock it with the fire alarm so doors release on alarm, and set up the management software with your staff, schedules and zones. Attendance data is exported in the format your payroll needs.</p>'
                    .'<p>Handover includes administrator training, a door schedule and audit trail setup, with ongoing support for enrolments and hardware.</p>',
                'capabilities' => [
                    ['title' => 'Biometric verification', 'description' => 'Fingerprint, facial recognition and iris readers for doors and restricted areas.'],
                    ['title' => 'Card and fob access', 'description' => 'RFID badges with issuing, revocation and lost-card handling.'],
                    ['title' => 'Door hardware', 'description' => 'Magnetic locks, electric strikes, exit buttons, turnstiles and boom-gate integration.'],
                    ['title' => 'Time and attendance', 'description' => 'Automatic clock-in records exported to your payroll.'],
                    ['title' => 'Central management', 'description' => 'One console for policies, schedules, zones and audit trails across sites.'],
                    ['title' => 'Visitor management', 'description' => 'Temporary credentials with expiry and full visit logs.'],
                ],
                'deliverables' => ['Door schedule and access rules', 'Installed readers, locks and controllers', 'Configured management software', 'Administrator training'],
                'applications' => ['Server rooms and data centres', 'Bank and SACCO branches', 'Manufacturing plants', 'Corporate offices', 'Campuses and hostels'],
                'brands' => [],
                'hero_image' => null,
            ],
            [
                'name' => 'Fiber installation',
                'slug' => 'fiber-installation',
                'icon' => 'cable',
                'tagline' => 'Backbones that carry everything, tested and certified.',
                'summary' => 'Optical fiber design and installation — ducted, aerial or blown — with professional splicing, termination and OTDR-certified test results for campus links, building risers and inter-site backbones.',
                'meta_title' => 'Fiber optic installation in Kenya',
                'meta_description' => 'Fiber optic installation in Kenya: route survey, ducted and aerial fiber, fusion splicing, ODF termination and OTDR-certified testing for campus backbones.',
                'body' => '<p>Fiber carries the traffic between buildings, floors and sites that copper cannot. It is also unforgiving: a tight bend or a poor splice costs you signal. Our fiber optic installation in Kenya is built for campuses, industrial parks, hospitals and high-rise risers.</p>'
                    .'<p>We survey the route, including ducts, poles and civil constraints, and design the link and its loss budget. We supply single-mode or multi-mode cable, pull, blow or string it, fusion splice and terminate into patch panels and ODFs, and test every core with an OTDR before handover. Links connect to your switches ready for use.</p>'
                    .'<p>You receive OTDR traces and loss results for every link and a route record. If a cable is ever cut, our team traces and re-splices the fault quickly.</p>',
                'capabilities' => [
                    ['title' => 'Route survey and design', 'description' => 'Duct, aerial and blown-fiber routes planned around the site and its civil constraints.'],
                    ['title' => 'Installation', 'description' => 'Single-mode and multi-mode fiber pulled, blown or strung, with correct bend radius and protection.'],
                    ['title' => 'Splicing and termination', 'description' => 'Fusion splicing, pigtails, patch panels and ODF build.'],
                    ['title' => 'OTDR testing and certification', 'description' => 'Loss budgets verified and documented for every link.'],
                    ['title' => 'Campus and inter-building links', 'description' => 'Connecting blocks, gatehouses, warehouses and remote offices.'],
                    ['title' => 'Fault location and repair', 'description' => 'Rapid response fiber fault tracing and re-splicing.'],
                ],
                'deliverables' => ['Route design and loss budget', 'Spliced and terminated fiber links', 'OTDR test results for every core', 'Route documentation'],
                'applications' => ['Multi-building campuses', 'Industrial parks', 'Hospitals', 'ISP and last-mile links', 'High-rise risers'],
                'brands' => [],
                'hero_image' => null,
            ],
        ];
    }
}
