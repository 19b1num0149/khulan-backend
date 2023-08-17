<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Permission;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomCount = rand(1, 10);
        $permissionIds = \App\Models\Permission::pluck('id')->toArray();
        return [
            'permission_id' => json_encode($this->faker->randomElements($permissionIds, $randomCount)),
        ];
    }
}
