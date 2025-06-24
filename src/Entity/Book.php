<?php

namespace App\Entity;

use App\Enum\Genre;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BookRepository::class)]
#[UniqueEntity(
    fields: ['isbn'],
    message: 'There is already an ISBN with that value.'
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 13, unique: true, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 13, max: 13)]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $publicationDate = null;

    #[ORM\Column(length: 255, nullable: false, enumType: Genre::class)]
    #[Assert\NotBlank]
    private ?Genre $genre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    #[Assert\Length(max: 8)]
    private ?int $numberOfCopies = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Author $author = null;

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

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeImmutable $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNumberOfCopies(): ?int
    {
        return $this->numberOfCopies;
    }

    public function setNumberOfCopies(?int $numberOfCopies): static
    {
        $this->numberOfCopies = $numberOfCopies;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }
}
