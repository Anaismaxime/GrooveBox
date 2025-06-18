<?php

namespace App\Entity;

use App\Repository\SoundtracksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoundtracksRepository::class)]
class Soundtracks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(length: 255)]
    private ?string $urlSoundtrack = null;

    #[ORM\ManyToOne(inversedBy: 'soundtracks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genres $genre = null;

    /**
     * @var Collection<int, Artists>
     */
    #[ORM\ManyToMany(targetEntity: Artists::class, mappedBy: 'producedTracks')]
    private Collection $artists;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'favorite_soundtracks')]
    private Collection $users;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->users = new ArrayCollection();
    }


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

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getUrlSoundtrack(): ?string
    {
        return $this->urlSoundtrack;
    }

    public function setUrlSoundtrack(string $urlSoundtrack): static
    {
        $this->urlSoundtrack = $urlSoundtrack;

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

    /**
     * @return Collection<int, Artists>
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artists $artist): static
    {
        if (!$this->artists->contains($artist)) {
            $this->artists->add($artist);
            $artist->addProducedTrack($this);
        }

        return $this;
    }

    public function removeArtist(Artists $artist): static
    {
        if ($this->artists->removeElement($artist)) {
            $artist->removeProducedTrack($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavoriteSoundtrack($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavoriteSoundtrack($this);
        }

        return $this;
    }


}
