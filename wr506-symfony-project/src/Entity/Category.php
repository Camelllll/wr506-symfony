<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_USER')"),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Get(security: "is_granted('ROLE_USER')"),
        new Delete(security: "is_granted('ROLE_ADMIN')"),
        new Patch(security: "is_granted('ROLE_ADMIN')"),
    ],
    normalizationContext: [
        'groups' => ['movie:read'],
    ],
    denormalizationContext: [
        'groups' => ['movie:write'],
    ],
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'movie:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'movie:read'])]
    #[Assert\NotBlank(message: 'Le nom de la catégorie ne doit pas être vide')]
    #[Assert\Length(
        min: 2,
        max: 50,
        maxMessage: 'Le nom de la catégorie doit faire entre {{ limit }} caractères maximum'
    )]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Movie::class)]
    #[Groups(['category:read'])]
    private Collection $movies;

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->setCategory($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getCategory() === $this) {
                $movie->setCategory(null);
            }
        }

        return $this;
    }

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
