<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="fk_person_share_group_idx", columns={"share_group_id"})})
 * @ORM\Entity
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var ShareGroup
     *
     * @ORM\ManyToOne(targetEntity="ShareGroup", inversedBy="person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="share_group_id", referencedColumnName="id")
     * })
     */
    private $shareGroup;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Expense", mappedBy="person")
     */
    private $expenses;

    /**
     * Person constructor.
     */
    public function __construct()
    {
        $this->expenses = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    /**
     * @param Collection $expenses
     */
    public function setExpenses(Collection $expenses): void
    {
        $this->expenses = $expenses;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getShareGroup(): ?ShareGroup
    {
        return $this->shareGroup;
    }

    public function setShareGroup(?ShareGroup $shareGroup): self
    {
        $this->shareGroup = $shareGroup;

        return $this;
    }


}
