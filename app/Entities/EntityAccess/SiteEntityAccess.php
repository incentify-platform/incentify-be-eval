<?php

namespace App\Entities\EntityAccess;

use App\Entities\EntityAccess;
use App\Entities\Site;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="entity_access")
 */
class SiteEntityAccess extends EntityAccess
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Site", inversedBy="entityAccess")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * @var Site|null
     */
    protected ?Site $site;

    /**
     * @return Site|null
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param Site|null $site
     */
    public function setSite(?Site $site): void
    {
        $this->site = $site;
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->site->getId();
    }

}
