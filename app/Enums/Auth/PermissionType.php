<?php

namespace App\Enums\Auth;

use App\Enums\Traits\EnumToArray;

enum PermissionType: string
{
    use EnumToArray;

    case USER_ACCESS = 'user_access';
    case USER_MANAGE = 'user_manage';

    //case EVENT_ACCESS = 'event_access';
    //case EVENT_MANAGE = 'event_manage';

    //case RESERBATION_ACCESS = 'reservation_access';
    //case RESERBATION_MANAGE = 'reservation_manage';

    
}
