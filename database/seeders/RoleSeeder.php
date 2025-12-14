<?php

namespace Database\Seeders;

use App\Enums\Auth\RoleType;
use Illuminate\Database\Seeder;
use App\Enums\Auth\PermissionType;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Uruchomienie konkretnego seedera:
        // sail artisan db:seed --class=RoleSeeder

        // Reset cache'a ról i uprawnień:
        // sail artisan permission:cache-reset
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => RoleType::ADMIN]);
        Role::create(['name' => RoleType::USER]);
        Role::create(['name' => RoleType::SERWISANT]);

        // ADMINISTRATOR SYSTEMU
        $userRole = Role::findByName(RoleType::ADMIN->value);
        $userRole->givePermissionTo(PermissionType::USER_ACCESS->value);
        $userRole->givePermissionTo(PermissionType::USER_MANAGE->value);
        $userRole->givePermissionTo(PermissionType::DEVICE_ACCESS->value);
        $userRole->givePermissionTo(PermissionType::DEVICE_MANAGE->value);
        $userRole->givePermissionTo(PermissionType::PARAMETER_ACCESS->value);
        $userRole->givePermissionTo(PermissionType::PARAMETER_MANAGE->value);
        
        $userRole->givePermissionTo(PermissionType::SERWISANT_DEVICE_ACCESS->value);
        $userRole->givePermissionTo(PermissionType::SERWISANT_DEVICE_MANAGE->value);
        //$userRole->givePermissionTo(PermissionType::RESERBATION_ACCESS->value);
        //$userRole->givePermissionTo(PermissionType::RESERBATION_MANAGE->value);
        
        // SERWISANT
        $userRole = Role::findByName(RoleType::SERWISANT->value);
        $userRole->givePermissionTo(PermissionType::DEVICE_ACCESS->value);
        $userRole->givePermissionTo(PermissionType::DEVICE_MANAGE->value);

        // UŻYTKOWNIK
    }
}
