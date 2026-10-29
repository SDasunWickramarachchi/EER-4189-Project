<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds for services.
     */
    public function run(): void
    {
        // Clear existing services
        Service::truncate();

        $services = [
            [
                'name' => 'Newbaby & Born',
                'description' => 'Capturing the delicate first chapters of life with a minimalist and emotive approach. We focus on the pure, unscripted moments between parents and their little ones, using soft natural light to create timeless portraits that feel as gentle as a lullaby.',
                'image_url' => '/images/gallery-3.jpg',
                'status' => 'active',
                'button_text' => 'Inquire For Full Detail Package',
                'button_link' => '/booking',
                'display_order' => 1,
            ],
            [
                'name' => 'Maternity',
                'description' => 'Celebrating the strength and grace of motherhood. Our maternity sessions are designed to be an editorial experience, focusing on elegant silhouettes and the profound emotional connection of this transformative journey.',
                'image_url' => '/images/gallery-2.jpg',
                'status' => 'active',
                'button_text' => 'Inquire For Full Detail Package',
                'button_link' => '/booking',
                'display_order' => 2,
            ],
            [
                'name' => 'Events',
                'description' => 'Documenting life\'s grandest celebrations with a cinematic eye. From intimate weddings to significant milestones, we capture the atmosphere, the details, and the raw emotions that make your events unforgettable.',
                'image_url' => '/images/gallery-1.jpg',
                'status' => 'active',
                'button_text' => 'Inquire For Full Detail Package',
                'button_link' => '/booking',
                'display_order' => 3,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
