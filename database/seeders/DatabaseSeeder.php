<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Content;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\GroupEventItinerary;
use App\Models\GroupEventMember;
use App\Models\GroupInterest;
use App\Models\GroupMember;
use App\Models\GroupMemberCoupon;
use App\Models\Interest;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInterest;
use App\Models\UserPoint;
use App\Models\UserService;
use App\Models\UserSettings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Role::factory(3)->create();
        // User::factory(3)->create();
        Group::factory(2)->create();
        // Permission::factory(5)->create();
        // Invoice::factory(3)->create();
        // Activity::factory(3)->create();
        // Content::factory(4)->create();
        // GroupMember::factory(10)->create();
        // GroupMemberCoupon::factory(3)->create();
        // UserPoint::factory(4)->create();
        // GroupInterest::factory(4)->create();
        // Interest::factory(4)->create();
        // GroupEventItinerary::factory(3)->create();
        // GroupEvent::factory(3)->create();
        // Notification::factory(3)->create();
        // UserService::factory(3)->create();
        // UserInterest::factory(5)->create();
        // UserSettings::factory(5)->create();
        // GroupEventMember::factory(5)->create();
    }
}
