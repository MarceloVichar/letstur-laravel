<?php

namespace App\Domain\Account\Enums;

use App\Support\Enum;

class RoleEnum extends Enum
{
    public const ADMIN = 'admin';

    public const COMPANY_ADMIN = 'company_admin';

    public const COMPANY_OPERATOR = 'company_operator';
}
