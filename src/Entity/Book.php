<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $author;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="date")
     */
    private $dateParution;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEdition;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrPage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $editor;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $ean;

    /**
     * @ORM\ManyToMany(targetEntity=author::class, inversedBy="books")
     */
    private $author;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    // public function getAuthor(): ?string
    // {
    //     return $this->author;
    // }

    // public function setAuthor(string $author): self
    // {
    //     $this->author = $author;

    //     return $this;
    // }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getDateParution(): ?\DateTimeInterface
    {
        return $this->dateParution;
    }

    public function setDateParution(\DateTimeInterface $dateParution): self
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->dateEdition;
    }

    public function setDateEdition(\DateTimeInterface $dateEdition): self
    {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    public function getNbrPage(): ?int
    {
        return $this->nbrPage;
    }

    public function setNbrPage(int $nbrPage): self
    {
        $this->nbrPage = $nbrPage;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * @return Collection<int, author>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(author $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author[] = $author;
        }

        return $this;
    }

    public function removeAuthor(author $author): self
    {
        $this->author->removeElement($author);

        return $this;
    }
}
