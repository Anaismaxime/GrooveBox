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

    public function __construct()
    {
        $this->soundtracks = new ArrayCollection();
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
}
