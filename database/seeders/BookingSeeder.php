<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds for bookings.
     */
    public function run(): void
    {
        // Clear existing bookings
        Booking::truncate();

        $bookings = [
            [
                'client_name' => 'Sarah Jenkins & Liam Vance',
                'client_phone' => '(415) 890-2134',
                'client_email' => 's.jenkins@vancemedia.com',
                'session_date' => '2024-10-14',
                'start_time' => '10:00 AM',
                'end_time' => '08:00 PM',
                'session_type' => 'Weddings & Couples',
                'location' => 'St. Jude Estate - Kenwood, Sonoma Valley',
                'status' => 'confirmed',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => 'Full day wedding coverage.',
            ],
            [
                'client_name' => 'Elena Vance',
                'client_phone' => '(510) 332-9011',
                'client_email' => 'elena.vance@archstudio.co',
                'session_date' => '2024-10-24',
                'start_time' => '02:30 PM',
                'end_time' => '05:00 PM',
                'session_type' => 'Portraits & Lifestyle',
                'location' => 'Studio Bay 1 (Main Loft) - Kenwood, Sonoma Valley',
                'status' => 'confirmed',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => 'Architectural portrait session.',
            ],
            [
                'client_name' => 'Apex Capital Partners',
                'client_phone' => '(415) 412-8820',
                'client_email' => 'c.montague@apexcap.com',
                'session_date' => '2024-11-04',
                'start_time' => '09:00 AM',
                'end_time' => '01:30 PM',
                'session_type' => 'Events & Corporate',
                'location' => 'Financial District Studio - 555 California St, Floor 38',
                'status' => 'pending',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => 'Corporate annual summit session.',
            ],
            [
                'client_name' => 'Marcus Thorne & Chloe Dupuis',
                'client_phone' => '(415) 773-1904',
                'client_email' => 'marcus@thorneheritage.com',
                'session_date' => '2024-11-18',
                'start_time' => '01:00 PM',
                'end_time' => '11:00 PM',
                'session_type' => 'Weddings & Couples',
                'location' => 'Palace Hotel Ballroom - San Francisco & Presidio Grounds',
                'status' => 'confirmed',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => 'Grand reception and grounds shoot.',
            ],
            [
                'client_name' => 'Claire Beauchamp',
                'client_phone' => '(831) 594-7120',
                'client_email' => 'claire.b@beauchamp.org',
                'session_date' => '2024-09-28',
                'start_time' => '10:00 AM',
                'end_time' => '08:00 PM',
                'session_type' => 'Maternity',
                'location' => 'Coastline Cliffs - Carmel Highlands, Big Sur Coast',
                'status' => 'confirmed',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => 'Outdoor sunset session.',
            ],
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}
