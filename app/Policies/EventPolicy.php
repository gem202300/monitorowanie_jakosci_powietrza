<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use App\Enums\Auth\PermissionType;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can(PermissionType::EVENT_MANAGE->value);
    }

    public function update(User $user, Event $event)
    {
        return $user->can(PermissionType::EVENT_MANAGE->value);
    }

    public function delete(User $user, Event $event)
    {
        return $user->can(PermissionType::EVENT_MANAGE->value);
    }
}
