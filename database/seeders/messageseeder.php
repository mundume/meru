<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;

class messageseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = [
            [
                'name' => 'PAID_TICKET',
                'body' => 'Ticket number:- %ticket_no% %break%Amount paid KSh %amount% for seat no %seat_no%. %break%Book ticket online via %link%'
            ],
            [
                'name' => 'ADMIN_REPORT',
                'body' => 'Daily Report%break%Bookings #%booking_count% /= %booking_sum% %break%Parcels # %parcel_count% /= %parcel_sum'
            ],
            [
                'name' => 'AGENT_CODE',
                'body' => 'Login Code%break%Passcode:- %password% %break%%link%/dashboard'
            ],
            [
                'name' => 'PARCEL_SENDER',
                'body' => 'Parcel received %break%Parcel number #%parcel_no% %break%Book ticket online via %link% %break%Thank you for choosing to send parcel with us.'
            ],
            [
                'name' => 'PARCEL_RECEIVER',
                'body' => 'Dear %name%, %break% Your parcel has been dispatched. Parcel number #%parcel_no% %break%Kindly check it arrival on our offices %break%Book ticket online via %link% %break%Thank you for choosing to send parcel with us.'
            ],
            [
                'name' => 'COLLECT_PARCEL',
                'body' => 'Greetings,%break%Kindly collect your parcel at our %office% or request a door delivery by calling %mobile%%break%Book ticket online via %link% %break%Thank you for choosing to send parcel with us.'  
            ],
            [
                'name' => 'TICKET_STATUS',
                'body' => 'Ticket Status %break%%link%/route/booking/status/%ticket_no%'
            ]
        ];
        foreach ($messages as $message) {
            Message::create($message);
        }
    }
}
