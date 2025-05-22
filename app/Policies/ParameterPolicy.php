<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Parameter;
use App\Enums\Auth\PermissionType;

class ParameterPolicy
{

    public function view(User $user, PARAMETER $PARAMETER): bool
    {
        return $user->hasPermissionTo(PermissionType::PARAMETER_ACCESS->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::PARAMETER_MANAGE->value);
    }

    public function update(User $user, PARAMETER $PARAMETER): bool
    {
        return $user->hasPermissionTo(PermissionType::PARAMETER_MANAGE->value);
    }

    public function delete(User $user, PARAMETER $PARAMETER): bool
    {
        return $user->hasPermissionTo(PermissionType::PARAMETER_MANAGE->value);
    }
}
