<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        // $userRole = Role::create(['name' => 'user']);
        $guruRole = Role::create(['name' => 'guru']);

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

        $user = User::create([
            'name' => 'Constent',
            'email' => 'test@cizzara.in',
            'email_verified_at' => date('Y-m-d h:i:s'),
            'password' => bcrypt('password'),
        ]);
        // $user->assignRole('user');

        $j1 = User::create([
            'name' => 'Guru1',
            'email' => 'g1@guru.com',
            'email_verified_at' => date('Y-m-d h:i:s'),
            'password' => bcrypt('password'),
        ]);
        $j1->assignRole('guru');

        $j2 = User::create([
            'name' => 'Guru2',
            'email' => 'g2@guru.com',
            'email_verified_at' => date('Y-m-d h:i:s'),
            'password' => bcrypt('password'),
        ]);
        $j2->assignRole('guru');

        $j3 = User::create([
            'name' => 'Guru3',
            'email' => 'g3@guru.com',
            'email_verified_at' => date('Y-m-d h:i:s'),
            'password' => bcrypt('password'),
        ]);
        $j3->assignRole('guru');

        $folder = 'TNSS-S1';
        $plans = Plan::create([
            'name' => $folder,
            'is_active' => 1,
            'price' => '199.99',
            'logo' => 'images/singinglogo-768x432.png'
            // 'gurus' => json_encode([$j1->id, $j2->id, $j3->id])
        ]);
        // TODO::create folder when creating plan
        if (!Storage::disk('s3')->exists($folder)) {
            Storage::disk('s3')->makeDirectory($folder);
        }

        $folder = 'TNDS-S1';
        $plans = Plan::create([
            'name' => $folder,
            'is_active' => 0,
            'price' => '999.99',
            'logo' => 'images/dancelogo-768x432.png'
            // 'gurus' => json_encode([$j1->id, $j2->id, $j3->id])
        ]);

        // TODO::create folder when creating plan
        if (!Storage::disk('s3')->exists($folder)) {
            Storage::disk('s3')->makeDirectory($folder);
        }
    }
}
