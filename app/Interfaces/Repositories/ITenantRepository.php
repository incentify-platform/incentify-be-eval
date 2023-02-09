<?php

namespace App\Interfaces\Repositories;

use App\Entities\Member;

interface ITenantRepository
{

    public function getMemberById(int $id): ?Member;
}
