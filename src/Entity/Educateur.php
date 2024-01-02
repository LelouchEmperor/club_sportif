<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\EducateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducateurRepository::class)]
class Educateur implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numeroLicence = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $contact = null;

    #[ORM\Column(length: 75)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $motDePasse = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isAdmin = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNumeroLicence(): ?int
    {
        return $this->numeroLicence;
    }

    public function setNumeroLicence(int $numeroLicence): static
    {
        $this->numeroLicence = $numeroLicence;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getRoles(): array
    {
        // Si l'éducateur a l'attribut isAdmin à true, donnez-lui le rôle 'ROLE_ADMIN'
        return $this->isAdmin ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
        // Vous pouvez également utiliser une autre propriété qui identifie de manière unique l'utilisateur.
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function getSalt(): ?string
    {
        // Vous n'avez pas besoin de sel si vous utilisez un hachage moderne comme Bcrypt.
        return null;
    }

    public function eraseCredentials(): void
    {
        // Méthode appelée lors de l'effacement des informations d'identification sensibles.
        // Dans la plupart des cas, cela ne nécessite aucune action.
    }
}
