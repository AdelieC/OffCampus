<?php

namespace App\Entity;

use App\Repository\OutingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OutingRepository::class)
 */
class Outing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="outings")
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="outings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organiser;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=OutingImage::class, mappedBy="outing", cascade={"persist", "remove"})
     */
    private $outingImage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dayAndTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date")
     */
    private $closingDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fare;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOrganiser(): ?User
    {
        return $this->organiser;
    }

    public function setOrganiser(?User $organiser): self
    {
        $this->organiser = $organiser;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOutingImage(): ?OutingImage
    {
        return $this->outingImage;
    }

    public function setOutingImage(?OutingImage $outingImage): self
    {
        // unset the owning side of the relation if necessary
        if ($outingImage === null && $this->outingImage !== null) {
            $this->outingImage->setOuting(null);
        }

        // set the owning side of the relation if necessary
        if ($outingImage !== null && $outingImage->getOuting() !== $this) {
            $outingImage->setOuting($this);
        }

        $this->outingImage = $outingImage;

        return $this;
    }

    public function getDayAndTime(): ?\DateTimeInterface
    {
        return $this->dayAndTime;
    }

    public function setDayAndTime(\DateTimeInterface $dayAndTime): self
    {
        $this->dayAndTime = $dayAndTime;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getClosingDate(): ?\DateTimeInterface
    {
        return $this->closingDate;
    }

    public function setClosingDate(\DateTimeInterface $closingDate): self
    {
        $this->closingDate = $closingDate;

        return $this;
    }

    public function getFare(): ?int
    {
        return $this->fare;
    }

    public function setFare(?int $fare): self
    {
        $this->fare = $fare;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }
}
