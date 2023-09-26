<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NationalityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NationalityRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['nationality:read']
    ],
)]
class Nationality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
