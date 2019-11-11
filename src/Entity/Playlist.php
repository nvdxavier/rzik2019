<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaylistRepository")
 */
class Playlist
{

    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="playlist", cascade={"remove", "persist"})
     */
    private $member;


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="MusicFile", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $musicfile;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plname;
    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreatepl;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionpl;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->musicfile = new ArrayCollection();
        $this->member = new ArrayCollection();
        $this->datecreatepl = new DateTime('NOW');
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlname(): ?string
    {
        return $this->plname;
    }

    public function setPlname(?string $plname): self
    {
        $this->plname = $plname;

        return $this;
    }

    public function getDatecreatepl(): ?DateTimeInterface
    {
        return $this->datecreatepl;
    }

    public function setDatecreatepl(DateTimeInterface $datecreatepl): self
    {
        $this->datecreatepl = $datecreatepl;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDescriptionpl(): ?string
    {
        return $this->descriptionpl;
    }

    public function setDescriptionpl(?string $descriptionpl): self
    {
        $this->descriptionpl = $descriptionpl;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|MusicFile[]
     */
    public function getMusicfile(): Collection
    {
        return $this->musicfile;
    }

    public function addMusicfile(MusicFile $musicfile): self
    {
        if (!$this->musicfile->contains($musicfile)) {
            $this->musicfile[] = $musicfile;
        }

        return $this;
    }

    public function removeMusicfile(MusicFile $musicfile): self
    {
        if ($this->musicfile->contains($musicfile)) {
            $this->musicfile->removeElement($musicfile);
        }

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
