<?php

namespace App\Services;

use App\Entities\Member;
use App\Interfaces\Repositories\ITenantRepository;
use App\Interfaces\Services\IAuthService;
use Illuminate\Validation\UnauthorizedException;

class AuthService implements IAuthService
{
    protected ITenantRepository $tenantRepo;

    public function __construct(ITenantRepository $tenantRepo) {
        $this->tenantRepo = $tenantRepo;
    }

    public function getAuthedMember(): Member
    {
        $member = auth()->guard('api')->user(); //TODO: inject auth cleanly here instead
        if(!isset($member->id)) {
            throw new UnauthorizedException("No valid member found for request");
        }
        return $this->tenantRepo->getMemberById($member->id);
    }

    public function hasAuthedMember(): bool {
        try {
            $member = $this->getAuthedMember();
            if(isset($member) && $member->getId() > 0) {
                return true;
            }
        } catch (\Exception $ex) {
            return false;
        }
        return false;
    }

}
