<?php

namespace App\Entity;

use App\Repository\BienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BienRepository::class)]
class Bien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?int $nb_pieces = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private array $autres = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    private ?string $Adresse = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank]
    private ?string $code_postal = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'biens')]
    private ?Type $type = null;

    #[ORM\OneToMany(mappedBy: 'Bien', targetEntity: Images::class)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbPieces(): ?int
    {
        return $this->nb_pieces;
    }

    public function setNbPieces(?int $nb_pieces): self
    {
        $this->nb_pieces = $nb_pieces;

        return $this;
    }

    public function getAutres(): array
    {
        return $this->autres;
    }

    public function setAutres(?array $autres): self
    {
        $this->autres = $autres;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

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

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setBien($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            if ($this->images->removeElement($image)) {
                // set the owning side to null (unless already changed)
                if ($image->getBien() === $this) {
                    $image->setBien(null);
                }
            }
        }

        return $this;
    }


}