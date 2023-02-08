<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tenant")
 */
class Tenant
{
    public const TYPE_ENTERPRISE = 'enterprise';
    public const TYPE_TRIAL = 'trial';
    public const TYPE_BASIC = 'basic';
    public const TYPE_PARTNER = 'partner';

    public const ALLOWED_TYPES = [
        self::TYPE_ENTERPRISE,
        self::TYPE_TRIAL,
        self::TYPE_BASIC,
        self::TYPE_PARTNER,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="primary_user_id", referencedColumnName="id", nullable=false)
     * @var User
     */
    protected User $primaryUser;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $title;

    /**
     * @ORM\ManyToOne(targetEntity="Tenant", fetch="EAGER")
     * @ORM\JoinColumn(name="parent_tenant_id", referencedColumnName="id", nullable=true)
     * @var Tenant|null
     */
    protected ?Tenant $parent;

    /**
     * @ORM\OneToMany(targetEntity="Tenant", mappedBy="parent")
     * @var Collection | Tenant[]
     */
    protected Collection $children;

    /**
     * @ORM\OneToMany(targetEntity="Member", mappedBy="tenant")
     * @var Collection | Member[]
     */
    protected Collection $members;

    /**
     * @ORM\OneToMany(targetEntity="Site", mappedBy="tenant")
     * @var Collection | Site[]
     */
    protected Collection $sites;


    /**
     * @ORM\OneToMany(targetEntity="LegalEntity", mappedBy="tenant")
     * @var Collection | LegalEntity[]
     */
    protected Collection $legalEntities;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $type;

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
        $this->members = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->sites = new ArrayCollection();
        $this->legalEntities = new ArrayCollection();
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
     * @return User
     */
    public function getPrimaryUser(): User
    {
        return $this->primaryUser;
    }

    /**
     * @param User $primaryUser
     */
    public function setPrimaryUser(User $primaryUser): void
    {
        $this->primaryUser = $primaryUser;
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
     * @return Tenant|null
     */
    public function getParent(): ?Tenant
    {
        return $this->parent;
    }

    /**
     * @param Tenant|null $parent
     */
    public function setParent(?Tenant $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children): void
    {
        $this->children = $children;
    }

    /**
     * @return Collection
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    /**
     * @param Collection $members
     */
    public function setMembers(Collection $members): void
    {
        $this->members = $members;
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
     * @return Collection
     */
    public function getLegalEntities(): Collection
    {
        return $this->legalEntities;
    }

    /**
     * @param Collection $legalEntities
     */
    public function setLegalEntities(Collection $legalEntities): void
    {
        $this->legalEntities = $legalEntities;
    }


}
