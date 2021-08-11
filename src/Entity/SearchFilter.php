<?php

namespace App\Entity;

use App\Repository\SearchFilterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchFilterRepository::class)
 */
class SearchFilter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $campus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $search;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $EndDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Organisator =false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $signIn =false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $notSignIn =false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $passed =false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampus(): ?string
    {
        return $this->campus;
    }

    public function setCampus(?string $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->EndDate;
    }

    public function setEndDate(?\DateTimeInterface $EndDate): self
    {
        $this->EndDate = $EndDate;

        return $this;
    }

    public function getOrganisator(): ?bool
    {
        return $this->Organisator;
    }

    public function setOrganisator(?bool $Organisator): self
    {
        $this->Organisator = $Organisator;

        return $this;
    }

    public function getSignIn(): ?bool
    {
        return $this->signIn;
    }

    public function setSignIn(?bool $signIn): self
    {
        $this->signIn = $signIn;

        return $this;
    }

    public function getNotSignIn(): ?bool
    {
        return $this->notSignIn;
    }

    public function setNotSignIn(?bool $notSignIn): self
    {
        $this->notSignIn = $notSignIn;

        return $this;
    }

    public function getPassed(): ?bool
    {
        return $this->passed;
    }

    public function setPassed(?bool $passed): self
    {
        $this->passed = $passed;

        return $this;
    }
}
