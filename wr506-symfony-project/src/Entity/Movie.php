<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
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
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[Groups(['movie:read', 'movie:write'])]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50, maxMessage: 'Le titre doit faire entre 2 et 50 caractères')]
    #[Groups(['movie:read', 'actor:read', 'category:read', 'movie:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'La description ne doit pas être vide'
    )]
    #[Groups(['movie:read', 'movie:write'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 1000,
        notInRangeMessage: 'La durée doit être comprise entre {{ min }} et {{ max }} minutes',
        invalidMessage: 'La durée doit être un nombre entier'
    )]
    #[Groups(['movie:read'])]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private Collection $actors;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['movie:read'])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(type: 'float' , nullable: true)]
    #[Assert\Range(
        min: 0,
        max: 10,
        notInRangeMessage: 'La note doit être comprise entre {{ min }} et {{ max }}',
        invalidMessage: 'La note doit être un nombre entier'
    )]
    #[Groups(['movie:read'])]
    private ?float $note = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Type(type: 'integer', message: 'Le nombre d\'entrées doit être un nombre entier')]
    #[Groups(['movie:read'])]
    private ?int $entries = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Type(type: 'integer', message: 'Le budget doit être un nombre entier')]
    #[Groups(['movie:read'])]
    private ?int $budget = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(
        message: 'Le réalisateur ne doit pas être vide'
    )]
    #[Assert\Length(min: 2, max: 50, maxMessage: 'Le réalisateur doit faire entre 2 et 50 caractères')]
    #[Groups(['movie:read'])]
    private ?string $director = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: 'Le site web doit être une URL valide')]
    #[Groups(['movie:read'])]
    private ?string $website = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read', 'movie:write'])]
    private ?string $poster = null;


    /**
     * @return Collection<int, Actor>
     */

     public function canBeViewedByUser(Security $security): bool
     {
         // Vérifie si l'utilisateur a le rôle ROLE_USER
         if (!$security->isGranted('ROLE_USER')) {
             return false;
         }
 
         return true;
     }
 
     public function canBeManagedByAdmin(Security $security): bool
     {
         // Vérifie si l'utilisateur a le rôle ROLE_ADMIN
         if (!$security->isGranted('ROLE_ADMIN')) {
             return false;
         }
 
         return true;
     }
     
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    public function __construct()
    {
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEntries(): ?int
    {
        return $this->entries;
    }

    public function setEntries(int $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }
}
