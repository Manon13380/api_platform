<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiFilter(OrderFilter::class, properties: ['title', 'year', 'author'])]
#[ApiResource(paginationClientItemsPerPage: true,
   normalizationContext: ['groups' => ['book:read']],
   denormalizationContext: ['groups' => ['book:write']],)]
class Book
{
    #[ApiProperty(identifier: true)]
    #[Groups(['book:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ApiProperty(readable: false)]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['book:read', 'book:write'])]
    #[Assert\NotBlank(message: "Le titre doit être renseigné")]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['book:read', 'book:write'])]
    #[Assert\NotBlank(message: "L'auteur doit être renseigné")]
    #[Assert\Length(min: 3, minMessage : "Le nom de l'auteur doit contenir au moins 3 caractères")]
    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[Groups(['book:read', 'book:write'])]
    #[Assert\Length(exactly: 4, exactMessage: "L'année doit contenir 4 chiffres")]
    #[ORM\Column(length: 4, nullable: true)]
    private ?string $year = null;

    #[Groups(['book:read', 'book:write'])]
    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
