<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Type is required")]

    private ?string $typelivraison = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Livraison::class, orphanRemoval: true)]

    private Collection $livraisons;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypelivraison(): ?string
    {
        return $this->typelivraison;
    }

    public function setTypelivraison(string $typelivraison): self
    {
        $this->typelivraison = $typelivraison;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setCategories($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getCategories() === $this) {
                $livraison->setCategories(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return(string)$this->getTypelivraison();
    }

}



