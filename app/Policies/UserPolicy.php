<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\Auth\PermissionType;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionType::USER_ACCESS->value);
    }

    public function view(User $user, User $model): bool
    {
        return $user->can(PermissionType::USER_ACCESS->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionType::USER_MANAGE->value);
    }

    public function update(User $user, User $model): bool
    {
        return $user->can(PermissionType::USER_MANAGE->value);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can(PermissionType::USER_MANAGE->value);
    }
}
