<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 * Vich\Uploadable()
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $firstName;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="author")
     */
    private $books;

    /**
     * @var string\null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File\null
     * @Vich\UploadableField(mapping="Avatar_image", fileNameProperty="filename")
     */
    private $imageFile; // stocks the path and the file name

    /**
     * @ORM\Column(type="date")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->addAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            $book->removeAuthor($this);
        }

        return $this;
    }

   /**
    * function to return full name
    *  @return string
    */ 
    public function getFullName(): string 
    {
        return $this->getFirstName(). " " . $this->getLastName();
    }

    public function getBirthFormat() 
    {
        return $this->getBirthDate()->format('l, d F Y');
    }


    public function getFilename(): ?string 
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): ?self {
        $this->filename = $filename;

        return $this;
    }

    public function getImageFile(): ?File 
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): ?self 
    {
        $this->imageFile = $imageFile;

        if($this->getImageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface 
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self 
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
