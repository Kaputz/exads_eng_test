<?php

namespace App\Entity;

use App\Repository\TvSeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TvSeriesRepository::class)]
class TvSeries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $channel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\OneToMany(mappedBy: 'id_tv_series', targetEntity: TvSeriesIntervals::class, orphanRemoval: true)]
    private Collection $tvSeriesIntervals;

    public function __construct()
    {
        $this->tvSeriesIntervals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): static
    {
        $this->channel = $channel;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, TvSeriesIntervals>
     */
    public function getTvSeriesIntervals(): Collection
    {
        return $this->tvSeriesIntervals;
    }

    public function addTvSeriesInterval(TvSeriesIntervals $tvSeriesInterval): static
    {
        if (!$this->tvSeriesIntervals->contains($tvSeriesInterval)) {
            $this->tvSeriesIntervals->add($tvSeriesInterval);
            $tvSeriesInterval->setIdTvSeries($this);
        }

        return $this;
    }

    public function removeTvSeriesInterval(TvSeriesIntervals $tvSeriesInterval): static
    {
        if ($this->tvSeriesIntervals->removeElement($tvSeriesInterval)) {
            // set the owning side to null (unless already changed)
            if ($tvSeriesInterval->getIdTvSeries() === $this) {
                $tvSeriesInterval->setIdTvSeries(null);
            }
        }

        return $this;
    }
}
