<?php

namespace App\GraphQL\Type;

use App\Entities\Tenant;
use Rebing\GraphQL\Support\EnumType;

class TenantTypeEnum extends EnumType
{

    protected $attributes = [
        'name'=>'TenantType',
        'description'=>'The supported tenant types',
        'values' => [
            'basic',
            'trial',
            'enterprise',
            'partner',
            //Tenant::ALLOWED_TYPES
        ],
    ];
}
