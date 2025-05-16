<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Device;
use App\Enums\Auth\PermissionType;

class DevicePolicy
{
    public function viewAny(User $user): bool
    {
        // будь-хто авторизований може бачити список
        return $user->hasPermissionTo(PermissionType::DEVICE_ACCESS->value);
    }

    public function view(User $user, Device $device): bool
    {
        return $user->hasPermissionTo(PermissionType::DEVICE_ACCESS->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::DEVICE_MANAGE->value);
    }

    public function update(User $user, Device $device): bool
    {
        return $user->hasPermissionTo(PermissionType::DEVICE_MANAGE->value);
    }

    public function delete(User $user, Device $device): bool
    {
        return $user->hasPermissionTo(PermissionType::DEVICE_MANAGE->value);
    }
}
