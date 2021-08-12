<?php

namespace App\Model;

use App\Entity\Campus;
use App\Entity\Ville;
use App\Repository\SearchFilterRepository;
use Doctrine\ORM\Mapping as ORM;


class SearchFilter
{

    private $id;


    private $campus;


    private $search;


    private $startDate;


    private $EndDate;


    private $Organisator =false;


    private $signIn =false;


    private $notSignIn =false;


    private $passed =false;


    private $ville;

    private $campusForm;


    public function getCampusForm(): ?string
    {
        return $this->campusForm;
    }


    public function setCampusForm($campusForm): self
    {
        $this->campusForm = $campusForm;
    }


    public function getVille(): ?string
    {
        return $this->ville;
    }


    public function setVille($ville): self
    {
        $this->ville = $ville;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
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
