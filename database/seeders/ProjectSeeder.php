<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Seed portfolio projects from the client's installation photography.
     *
     * client_name stays null until the client confirms which names may be published.
     */
    public function run(): void
    {
        $serviceIds = Service::pluck('id', 'slug');

        foreach ($this->projects() as $index => $project) {
            $services = $project['services'];
            unset($project['services']);

            $record = Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project + ['sort_order' => $index + 1, 'client_name' => null, 'location' => 'Nairobi, Kenya'],
            );

            $record->services()->sync($serviceIds->only($services)->values());
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function projects(): array
    {
        return [
            [
                'title' => 'Data and voice cabinet network rack build',
                'slug' => 'data-voice-cabinet-network-rack',
                'sector' => 'Corporate',
                'services' => ['data-voice-solutions', 'it-solutions'],
                'summary' => 'A row of enclosed network cabinets built out for a corporate server room, with equipment mounted, powered and cabled for data and voice.',
                'challenge' => 'The client needed a server room that could house network, server and telephony equipment together, with room to grow and cabinets that could be locked and ventilated.',
                'solution' => 'We installed a run of enclosed floor-standing cabinets on a raised floor, mounted switching and server equipment, dressed the power and data cabling inside each cabinet and terminated voice and data circuits on patch panels.',
                'outcome' => 'The equipment now sits in lockable, ventilated cabinets with labelled patching, leaving spare rack units for future expansion.',
                'cover_image' => 'images/projects/data-voice-cabinet-rack-1.jpg',
                'gallery' => ['images/projects/data-voice-cabinet-rack-1.jpg', 'images/projects/cctv-server-cabinet.jpg'],
                'is_featured' => true,
            ],
            [
                'title' => 'High-density patching installation',
                'slug' => 'high-density-patching-installation',
                'sector' => 'Corporate',
                'services' => ['data-voice-solutions'],
                'summary' => 'Open racks fitted with high-density patch panels and colour-coded patch leads, managed with vertical cable organisers.',
                'challenge' => 'A large number of network ports had to be patched in a limited floor area, while keeping every connection traceable for the operations team.',
                'solution' => 'We fitted high-density patch panels and vertical cable managers, patched each port with colour-coded leads by function, and routed cabling overhead on cable trays.',
                'outcome' => 'Each connection can be identified by colour and label, and technicians can reach any port without disturbing neighbouring links.',
                'cover_image' => 'images/projects/high-density-patching.jpg',
                'gallery' => ['images/projects/high-density-patching.jpg', 'images/projects/cctv-server-cabinet.jpg'],
                'is_featured' => true,
            ],
            [
                'title' => 'CCTV server cabinet deployment',
                'slug' => 'cctv-server-cabinet-deployment',
                'sector' => 'Corporate',
                'services' => ['cctv-installation', 'data-voice-solutions'],
                'summary' => 'Network cabinets housing the recording and switching equipment for an IP camera system.',
                'challenge' => 'The surveillance recorders and PoE switches needed a secure home close to the cable runs from the cameras.',
                'solution' => 'We installed the recorders and switches in cabinets alongside the data network, terminated the camera cabling on patch panels and labelled each camera circuit.',
                'outcome' => null,
                'cover_image' => 'images/projects/cctv-server-cabinet.jpg',
                'gallery' => ['images/projects/cctv-server-cabinet.jpg'],
            ],
            [
                'title' => 'CCTV monitoring display for a food outlet',
                'slug' => 'cctv-control-room-video-wall',
                'sector' => 'Hospitality and retail',
                'services' => ['cctv-installation'],
                'summary' => 'A wall-mounted monitoring screen showing a live multi-camera view of the dining area, kitchen, store room, entrance and service counter.',
                'challenge' => 'The management team wanted to see front-of-house, kitchen, storage and the outside approach at the same time, from one screen.',
                'solution' => 'We installed IP cameras across the dining area, service counter, kitchen, stores and the exterior, and mounted a monitoring display with a split-screen layout, leaving spare channels on the recorder for future cameras.',
                'outcome' => 'Eight live views are shown on one screen, with channels available to add more cameras without replacing the recorder.',
                'cover_image' => 'images/projects/cctv-control-room-video-wall.jpg',
                'gallery' => ['images/projects/cctv-control-room-video-wall.jpg'],
                'is_featured' => true,
            ],
            [
                'title' => 'CCTV preventive maintenance programme',
                'slug' => 'cctv-preventive-maintenance',
                'sector' => 'Corporate',
                'services' => ['cctv-installation'],
                'summary' => 'Scheduled maintenance for installed camera systems, including storage health checks and replacement of recorder drives with surveillance-rated disks.',
                'challenge' => 'Recorders running around the clock wear out their hard drives, and failures are often only discovered when footage is needed.',
                'solution' => 'Our maintenance visits cover lens cleaning, focus checks, firmware updates and storage health reports, with worn drives replaced by surveillance-rated disks.',
                'outcome' => null,
                'cover_image' => 'images/projects/cctv-preventive-maintenance.jpg',
                'gallery' => ['images/projects/cctv-preventive-maintenance.jpg'],
            ],
            [
                'title' => 'Biometric and access control installation',
                'slug' => 'biometric-access-control-cabinet',
                'sector' => 'Corporate',
                'services' => ['access-control-systems'],
                'summary' => 'Fingerprint readers and a keypad attendance terminal installed at controlled entry points.',
                'challenge' => 'The client needed to restrict access to certain areas and record staff attendance without relying on keys or sign-in books.',
                'solution' => 'We installed fingerprint and card readers at the doors, an attendance terminal with keypad at the staff entrance, and set up central management of users and access schedules.',
                'outcome' => null,
                'cover_image' => 'images/projects/biometric-access-control-cabinet.jpg',
                'gallery' => ['images/projects/biometric-access-control-cabinet.jpg'],
            ],
        ];
    }
}
