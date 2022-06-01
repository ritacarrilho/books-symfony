<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @method string getUserIdentifier()
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $role;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles()
    {
        return [$this->getRole()]; // returns an array with the role of the entity
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    // TODO: Implement eraseCredentials() method. 
    }

    public function getUsername()
    {
        return $this->getEmail;
    }

    public function __call($name, $arguments)
    {
    // TODO: Implement @method string getUserIdentifier() }
    }

    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getEmail(),
            $this->getPassword()
        ]);
    }

    public function unserialize($data)
    { // recovers the serielized data in serialize()
        list($this->id, $this->email, $this->password) = 
            unserialize($data, ['allowed_classes' => false]);
    }
}