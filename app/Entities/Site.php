<?php

namespace App\Entities;

use App\Entities\EntityAccess\LegalEntityAccess;
use App\Entities\EntityAccess\SiteEntityAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="site")
 */
class Site
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tenant", inversedBy="sites")
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
     * @var string|null
     */
    protected ?string $addressFull;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=true)
     * @var float|null
     */
    protected ?float $lat;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=true)
     * @var float|null
     */
    protected ?float $lng;

    /**
     * @ORM\ManyToOne(targetEntity="LegalEntity", inversedBy="sites")
     * @ORM\JoinColumn(name="legal_entity_id", referencedColumnName="id")
     * @var ?LegalEntity
     */
    protected ?LegalEntity $legalEntity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entities\EntityAccess\SiteEntityAccess", mappedBy="site")
     * @var Collection | SiteEntityAccess[]
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
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     */
    public function setLat(?float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float|null $lng
     */
    public function setLng(?float $lng): void
    {
        $this->lng = $lng;
    }

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

    /**
     * @return string|null
     */
    public function getAddressFull(): ?string
    {
        return $this->addressFull;
    }

    /**
     * @param string|null $addressFull
     */
    public function setAddressFull(?string $addressFull): void
    {
        $this->addressFull = $addressFull;
    }
}
