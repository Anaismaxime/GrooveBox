<?php

namespace App\Entity;

use App\Repository\ArtistsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistsRepository::class)]
class Artists
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $biography = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(length: 100)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlSoundcloud = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlSpotify = null;

    #[ORM\Column(nullable: true)]
    private ?bool $artistOfTheWeek = null;

    #[ORM\ManyToOne(inversedBy: 'artists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genres $genre = null;

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

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getUrlSoundcloud(): ?string
    {
        return $this->urlSoundcloud;
    }

    public function setUrlSoundcloud(?string $urlSoundcloud): static
    {
        $this->urlSoundcloud = $urlSoundcloud;

        return $this;
    }

    public function getUrlSpotify(): ?string
    {
        return $this->urlSpotify;
    }

    public function setUrlSpotify(?string $urlSpotify): static
    {
        $this->urlSpotify = $urlSpotify;

        return $this;
    }

    public function isArtistOfTheWeek(): ?bool
    {
        return $this->artistOfTheWeek;
    }

    public function setArtistOfTheWeek(?bool $artistOfTheWeek): static
    {
        $this->artistOfTheWeek = $artistOfTheWeek;

        return $this;
    }


    public function getGenre(): ?Genres
    {
        return $this->genre;
    }

    public function setGenre(?Genres $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

}
