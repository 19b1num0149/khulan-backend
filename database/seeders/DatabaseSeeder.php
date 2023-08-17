<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Content;
use App\Models\Group;
use App\Models\Group_Event;
use App\Models\Group_Event_Itinenary;
use App\Models\Group_Interest;
use App\Models\Group_Member;
use App\Models\Group_Member_Coupon;
use App\Models\Interest;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\User_Point;
use App\Models\User_Service;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory(3)->create();
        User::factory(10)->create();
        Group::factory(5)->create();
        Permission::factory(5)->create();
        Invoice::factory(3)->create();
        Activity::factory(3)->create();
        Content::factory(4)->create();
        Group_Member::factory(10)->create();
        Group_Member_Coupon::factory(3)->create();
        User_Point::factory(4)->create();
        Group_Interest::factory(4)->create();
        Interest::factory(4)->create();
        Group_Event_Itinenary::factory(3)->create();
        Group_Event::factory(3)->create();
        Notification::factory(3)->create();
        User_Service::factory(3)->create();
    }
}
