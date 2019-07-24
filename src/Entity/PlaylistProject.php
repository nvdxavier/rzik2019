<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaylistProjectRepository")
 */
class PlaylistProject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plprojectname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreateplproject;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $plprojectposition;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionplproject;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Picture", cascade={"remove", "persist"})
     */
    private $mainpictureplproject;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="playlistproject", cascade={"remove", "persist"})
     */
    private $picturesplproject;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\MusicFile", mappedBy="playlistproject", cascade={"remove", "persist"})
     */
    private $musicfileplproject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArtistBand", inversedBy="artistbandproject")
     */
    private $artistbandplproject;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="plprojectowner", cascade={"remove", "persist"})
     */
    private $imgplprojectowner;


    public function __construct()
    {
        $this->picturesplproject = new ArrayCollection();
        $this->musicfileplproject = new ArrayCollection();
        $this->imgplprojectowner = new ArrayCollection();
        $this->setDateCreated(new DateTime('now'));

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlprojectname(): ?string
    {
        return $this->plprojectname;
    }

    public function setPlprojectname(string $plprojectname): self
    {
        $this->plprojectname = $plprojectname;

        return $this;
    }

    public function getDatecreatePlproject(): ?DateTimeInterface
    {
        return $this->datecreateplproject;
    }

    public function setDatecreatePlproject(DateTimeInterface $datecreateplproject): self
    {
        $this->datecreateplproject = $datecreateplproject;

        return $this;
    }

    public function getPlprojectPosition(): ?int
    {
        return $this->plprojectposition;
    }

    public function setPlprojectPosition(?int $plprojectposition): self
    {
        $this->plprojectposition = $plprojectposition;

        return $this;
    }

    public function getDescriptionPlproject(): ?string
    {
        return $this->descriptionplproject;
    }

    public function setDescriptionPlproject(string $descriptionplproject): self
    {
        $this->descriptionplproject = $descriptionplproject;

        return $this;
    }

    /**
     * @return Collection|MusicFile[]
     */
    public function getMusicfilePlproject(): Collection
    {
        return $this->musicfileplproject;
    }

    public function setMusicfilePlproject(?string $musicfileplproject): self
    {
        $this->musicfileplproject = $musicfileplproject;

        return $this;
    }

    public function getArtistbandPlproject(): ?ArtistBand
    {
        return $this->artistbandplproject;
    }

    public function setArtistbandPlproject(?ArtistBand $artistbandplproject): self
    {
        $this->artistbandplproject = $artistbandplproject;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPicturesPlproject(): Collection
    {
        return $this->picturesplproject;
    }

    public function addPicturesPlproject(Picture $picturesPlproject): self
    {
        if (!$this->picturesplproject->contains($picturesPlproject)) {
            $this->picturesplproject[] = $picturesPlproject;
            $picturesPlproject->setPlaylistProject($this);
        }

        return $this;
    }

    public function removePicturesPlproject(Picture $picturesPlproject): self
    {
        if ($this->picturesplproject->contains($picturesPlproject)) {
            $this->picturesplproject->removeElement($picturesPlproject);
            // set the owning side to null (unless already changed)
            if ($picturesPlproject->getPlaylistProject() === $this) {
                $picturesPlproject->setPlaylistProject(null);
            }
        }

        return $this;
    }

    public function addMusicfilePlproject(MusicFile $musicfilePlproject): self
    {
        if (!$this->musicfileplproject->contains($musicfilePlproject)) {
            $this->musicfileplproject[] = $musicfilePlproject;
            $musicfilePlproject->setPlaylistproject($this);
        }

        return $this;
    }

    public function removeMusicfilePlproject(MusicFile $musicfilePlproject): self
    {
        if ($this->musicfileplproject->contains($musicfilePlproject)) {
            $this->musicfileplproject->removeElement($musicfilePlproject);
            // set the owning side to null (unless already changed)
            if ($musicfilePlproject->getPlaylistproject() === $this) {
                $musicfilePlproject->setPlaylistproject(null);
            }
        }

        return $this;
    }

    public function getMainpicturePlproject(): ?Picture
    {
        return $this->mainpictureplproject;
    }

    public function setMainpicturePlproject(?Picture $mainpictureplproject): self
    {
        $this->mainpictureplproject = $mainpictureplproject;

        return $this;
    }

    public function getDateCreated(): ?DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getImgplprojectowner(): Collection
    {
        return $this->imgplprojectowner;
    }

    public function addImgplprojectowner(Picture $imgplprojectowner): self
    {
        if (!$this->imgplprojectowner->contains($imgplprojectowner)) {
            $this->imgplprojectowner[] = $imgplprojectowner;
            $imgplprojectowner->setPlaylistproject($this);
        }

        return $this;
    }

    public function removeImgplprojectowner(Picture $imgplprojectowner): self
    {
        if ($this->imgplprojectowner->contains($imgplprojectowner)) {
            $this->imgplprojectowner->removeElement($imgplprojectowner);
            // set the owning side to null (unless already changed)
            if ($imgplprojectowner->getPlaylistproject() === $this) {
                $imgplprojectowner->setPlaylistproject(null);
            }
        }

        return $this;
    }


}
