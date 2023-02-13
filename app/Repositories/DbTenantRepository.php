<?php

namespace App\Repositories;

use App\Entities\Member;
use App\Entities\Tenant;
use App\Interfaces\Repositories\ITenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\Hash;

class DbTenantRepository extends EntityRepository implements ITenantRepository
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct($this->entityManager, $this->entityManager->getClassMetadata(Tenant::class));
    }

    public function getMemberById(int $id): ?Member
    {
        $dql = "SELECT m, u, t FROM ".Member::class." m JOIN m.user u JOIN m.tenant t WHERE m.id = ?1";

        $member = $this->entityManager->createQuery($dql)
            ->setParameter(1, $id)
            ->getOneOrNullResult();
        return $member;
    }

    public function getMemberByEmailPass(string $email, string $password): ?Member {
        $dql = "SELECT m, u, t FROM ".Member::class." m JOIN m.user u JOIN m.tenant t WHERE u.email = ?1";

        $member = $this->entityManager->createQuery($dql)
            ->setParameter(1, $email)
            ->getOneOrNullResult();

        if(isset($member)) {
            $pwCheckResult = Hash::check($password, $member->getUser()->getPassword());
            if($pwCheckResult === false) {
                return null;
            }
        }

        return $member;
    }
}
