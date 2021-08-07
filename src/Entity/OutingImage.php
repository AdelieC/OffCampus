<?php

namespace App\Entity;

use App\Repository\OutingImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OutingImageRepository::class)
 */
class OutingImage
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
     * @ORM\OneToOne(targetEntity=Outing::class, inversedBy="outingImage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $outing;

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

    public function getOuting(): ?Outing
    {
        return $this->outing;
    }

    public function setOuting(?Outing $outing): self
    {
        $this->outing = $outing;

        return $this;
    }
}
