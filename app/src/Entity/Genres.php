<?php

namespace App\Entity;

use App\Repository\GenresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenresRepository::class)]
class Genres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Soundtracks>
     */
    #[ORM\OneToMany(targetEntity: Soundtracks::class, mappedBy: 'genre')]
    private Collection $soundtracks;

    /**
     * @var Collection<int, Posts>
     */
    #[ORM\OneToMany(targetEntity: Posts::class, mappedBy: 'genre')]
    private Collection $posts;

    /**
     * @var Collection<int, Playlists>
     */
    #[ORM\OneToMany(targetEntity: Playlists::class, mappedBy: 'genre')]
    private Collection $playlists;

    public function __construct()
    {
        $this->soundtracks = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Soundtracks>
     */
    public function getSoundtracks(): Collection
    {
        return $this->soundtracks;
    }

    public function addSoundtrack(Soundtracks $soundtrack): static
    {
        if (!$this->soundtracks->contains($soundtrack)) {
            $this->soundtracks->add($soundtrack);
            $soundtrack->setGenre($this);
        }

        return $this;
    }

    public function removeSoundtrack(Soundtracks $soundtrack): static
    {
        if ($this->soundtracks->removeElement($soundtrack)) {
            // set the owning side to null (unless already changed)
            if ($soundtrack->getGenre() === $this) {
                $soundtrack->setGenre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Posts>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setGenres($this);
        }

        return $this;
    }

    public function removePost(Posts $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getGenre() === $this) {
                $post->setGenres(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlists>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlists $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setGenre($this);
        }

        return $this;
    }

    public function removePlaylist(Playlists $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getGenre() === $this) {
                $playlist->setGenre(null);
            }
        }

        return $this;
    }
}
