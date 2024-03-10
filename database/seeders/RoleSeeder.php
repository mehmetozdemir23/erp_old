<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->createSuperAdminRole();
    }

    protected function createRole(RoleName $role, Collection $permissions): void
    {
        $newRole = Role::create(['name' => $role->value]);
        $newRole->permissions()->sync($permissions);
    }

    protected function createSuperAdminRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'admin.%')
            ->orWhere('name', 'like', 'user.%')
            ->orWhere('name', 'like', 'product.%')
            ->pluck('id');

        $this->createRole(RoleName::SUPER_ADMIN, $permissions);
    }

    protected function createAdminRole(): void
    {
        $permissions = Permission::query()
            ->orWhere('name', 'like', 'user.%')
            ->orWhere('name', 'like', 'product.%')
            ->pluck('id');

        $this->createRole(RoleName::ADMIN, $permissions);
    }
}
