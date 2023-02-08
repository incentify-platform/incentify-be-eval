<?php

namespace App\Entities;

use App\Entities\EntityAccess\LegalEntityAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="legal_entity")
 */
class LegalEntity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tenant", inversedBy="legalEntities")
     * @ORM\JoinColumn(name="tenant_id", referencedColumnName="id")
     * @var Tenant
     */
    protected Tenant $tenant;

    /**
     * @ORM\ManyToOne(targetEntity="Member")
     * @ORM\JoinColumn(name="created_by_member_id", referencedColumnName="id")
     * @var Member
     */
    protected Member $createdByMember;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $type;

    /**
     * @ORM\OneToMany(targetEntity="Site", mappedBy="legalEntity")
     * @var Collection | Site[]
     */
    protected Collection $sites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entities\EntityAccess\LegalEntityAccess", mappedBy="legalEntity")
     * @var Collection | LegalEntityAccess[]
     */
    protected Collection $entityAccess;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected \DateTime $updatedAt;

    public function __construct() {
        $this->sites = new ArrayCollection();
        $this->entityAccess = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Tenant
     */
    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    /**
     * @param Tenant $tenant
     */
    public function setTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * @return Member
     */
    public function getCreatedByMember(): Member
    {
        return $this->createdByMember;
    }

    /**
     * @param Member $createdByMember
     */
    public function setCreatedByMember(Member $createdByMember): void
    {
        $this->createdByMember = $createdByMember;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Collection
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    /**
     * @param Collection $sites
     */
    public function setSites(Collection $sites): void
    {
        $this->sites = $sites;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Collection
     */
    public function getEntityAccess(): Collection
    {
        return $this->entityAccess;
    }

    /**
     * @param Collection $entityAccess
     */
    public function setEntityAccess(Collection $entityAccess): void
    {
        $this->entityAccess = $entityAccess;
    }


}
