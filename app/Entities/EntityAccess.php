<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

abstract class EntityAccess
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * @var Member
     */
    protected Member $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Member")
     * @ORM\JoinColumn(name="created_by_member_id", referencedColumnName="id")
     * @var Member
     */
    protected Member $createdByMember;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $entityType;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $entityId;

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
     * @return Member
     */
    public function getMember(): Member
    {
        return $this->member;
    }

    /**
     * @param Member $member
     */
    public function setMember(Member $member): void
    {
        $this->member = $member;
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
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @param string $entityType
     */
    public function setEntityType(string $entityType): void
    {
        $this->entityType = $entityType;
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     */
    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
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
     * @return LegalEntity|null
     */
    public function getLegalEntity(): ?LegalEntity
    {
        return null;
    }

    /**
     * @return Site|null
     */
    public function getSite(): ?Site
    {
        return null;
    }
}
