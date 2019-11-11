<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picturename;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picturefile;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $picturecategory = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="memberpicture", cascade={"remove", "persist"})
     */
    private $memberowner;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArtistBand", inversedBy="artistbandpicture", cascade={"remove", "persist"})
     */
    private $pictureartistband;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArtistBand", inversedBy="artistbandlogo", cascade={"remove", "persist"})
     */
    private $logoartistband;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlaylistProject", inversedBy="picturesplproject", cascade={"remove", "persist"})
     */
    private $playlistproject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlaylistProject", inversedBy="imgplprojectowner", cascade={"remove", "persist"})
     */
    private $plprojectowner;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicturename(): ?string
    {
        return $this->picturename;
    }

    public function setPicturename(?string $picturename): self
    {
        $this->picturename = $picturename;

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

    public function getPicturefile(): ?string
    {
        return $this->picturefile;
    }

    public function setPicturefile(?string $picturefile): self
    {
        $this->picturefile = $picturefile;

        return $this;
    }

    public function getPictureCategory(): ?array
    {
        return $this->picturecategory;
    }

    public function setPictureCategory(?array $picturecategory): self
    {
        $this->picturecategory = $picturecategory;

        return $this;
    }

    public function getPlprojectOwner(): ?PlaylistProject
    {
        return $this->plprojectowner;
    }

    public function setPlprojectOwner(?PlaylistProject $plprojectowner): self
    {
        $this->plprojectowner = $plprojectowner;

        return $this;
    }

    public function getMemberOwner(): ?Member
    {
        return $this->memberowner;
    }

    public function setMemberOwner(?Member $memberowner): self
    {
        $this->memberowner = $memberowner;

        return $this;
    }

    public function getPictureArtistband(): ?ArtistBand
    {
        return $this->pictureartistband;
    }

    public function setPictureArtistband(?ArtistBand $pictureartistband): self
    {
        $this->pictureartistband = $pictureartistband;

        return $this;
    }

    public function getLogoArtistband(): ?ArtistBand
    {
        return $this->logoartistband;
    }

    public function setLogoArtistband(?ArtistBand $logoartistband): self
    {
        $this->logoartistband = $logoartistband;

        return $this;
    }

    public function getPlaylistproject(): ?PlaylistProject
    {
        return $this->playlistproject;
    }

    public function setPlaylistproject(?PlaylistProject $playlistproject): self
    {
        $this->playlistproject = $playlistproject;

        return $this;
    }
}
