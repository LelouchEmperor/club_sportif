<?php

namespace App\Entity;

use App\Repository\LicencieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LicencieRepository::class)
 */
class Licencie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column
     */
    private ?int $numeroLicence = null;

    /**
     * @ORM\Column(length: 50)
     */
    private ?string $nom = null;

    /**
     * @ORM\Column(length: 50)
     */
    private ?string $prenom = null;

    /**
     * @ORM\Column(length: 255)
     */
    private ?string $contact = null;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Categorie $categorie = null;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Contact $contactEntity = null;

    /**
     * @ORM\Column(length: 255)
     */
    private ?string $educateur = null;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getContactEntity(): ?Contact
    {
        return $this->contactEntity;
    }

    public function setContactEntity(?Contact $contactEntity): static
    {
        $this->contactEntity = $contactEntity;

        return $this;
    }

    public function getEducateur(): ?string
    {
        return $this->educateur;
    }

    public function setEducateur(string $educateur): static
    {
        $this->educateur = $educateur;

        return $this;
    }
}
