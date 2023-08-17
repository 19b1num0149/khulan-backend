<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Permission::factory(10)->create();
        \App\Models\Role::factory(3)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\User_services::factory(5)->create();
        \App\Models\Group::factory(10)->create();
        \App\Models\Group_member::factory(30)->create();
        \App\Models\Interest::factory(5)->create();
        \App\Models\Group_interest::factory(30)->create();
        \App\Models\Group_event::factory(10)->create();
        \App\Models\Group_event_itineraries::factory(10)->create();
        \App\Models\Activities::factory(10)->create();
        \App\Models\Content::factory(10)->create();
        \App\Models\Invoices::factory(10)->create();
        \App\Models\Notification::factory(10)->create();
        \App\Models\Group_member_coupon::factory(10)->create();
    }
}
