<?php

namespace App\Interfaces\Services;

use App\Entities\Member;

interface IAuthService
{

    public function getAuthedMember(): Member;

    public function hasAuthedMember(): bool;
}
