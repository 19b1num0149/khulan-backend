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
        User::factory(10)->create();
  
    }
}
