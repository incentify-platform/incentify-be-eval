<?php

namespace App\Entities;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime|null
     */
    protected ?\DateTime $emailVerifiedAt;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected string $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    protected ?string $rememberToken;

    /**
     * @ORM\OneToMany(targetEntity="Member", mappedBy="user")
     * @var Collection | Member[]
     */
    protected Collection $memberships;

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
        $this->memberships = new ArrayCollection();
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime|null
     */
    public function getEmailVerifiedAt(): ?\DateTime
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param \DateTime|null $emailVerifiedAt
     */
    public function setEmailVerifiedAt(?\DateTime $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    /**
     * @param string|null $rememberToken
     */
    public function setRememberToken(?string $rememberToken): void
    {
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return Collection
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    /**
     * @param Collection $memberships
     */
    public function setMemberships(Collection $memberships): void
    {
        $this->memberships = $memberships;
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

}
