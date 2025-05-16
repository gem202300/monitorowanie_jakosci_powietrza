<?php

namespace App\Enums\Auth;

use App\Enums\Traits\EnumToArray;

enum PermissionType: string
{
    use EnumToArray;

    case USER_ACCESS = 'user_access';
    case USER_MANAGE = 'user_manage';

    case DEVICE_ACCESS = 'device_access';
    case DEVICE_MANAGE = 'device_manage';


    
}
