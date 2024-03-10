<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createSuperAdminUser();
    }

    public function createSuperAdminUser()
    {
        User::create([
            'name' => 'SuperAdmin User',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('password'),
        ])->roles()->sync(Role::where('name', RoleName::SUPER_ADMIN->value)->first());
    }
}
