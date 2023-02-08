<?php

namespace App\Entities\EntityAccess;

use App\Entities\EntityAccess;
use App\Entities\LegalEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="entity_access")
 */
class LegalEntityAccess extends EntityAccess
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\LegalEntity", inversedBy="entityAccess")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * @var LegalEntity|null
     */
    protected ?LegalEntity $legalEntity;

    /**
     * @return LegalEntity|null
     */
    public function getLegalEntity(): ?LegalEntity
    {
        return $this->legalEntity;
    }

    /**
     * @param LegalEntity|null $legalEntity
     */
    public function setLegalEntity(?LegalEntity $legalEntity): void
    {
        $this->legalEntity = $legalEntity;
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->legalEntity->getId();
    }

}
