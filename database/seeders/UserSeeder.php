<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Optionally, you can create permissions and assign them to roles
        // For example:
        // $createPostPermission = Permission::create(['name' => 'create post']);
        // $adminRole->givePermissionTo($createPostPermission);

        // Create a user with the admin role
        $user = User::create([
            'name' => 'TUP Admin',
            'email' => 'tup@admin.com',
            'email_verified_at' => date('Y-m-d h:i:s'),
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');

        $plans = Plan::create([
            'name' => 'SingTUV2024',
            'is_active' => 1,
            'price' => '10'
        ]);
        Log::info("insert seed".$plans->id ?? 0000);
        $plans = Plan::create([
            'name' => 'DanceTUV2023',
            'is_active' => 0,
            'price' => '999.99'
        ]);
    }
}
