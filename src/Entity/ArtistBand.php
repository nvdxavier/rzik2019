<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Member;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistBandRepository")
 */
class ArtistBand
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\PlaylistProject", mappedBy="artistbandplproject", cascade={"remove", "persist"})
     */
    protected $artistbandproject;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artistbandname;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $artistbanddescription;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $artistbanddateceation;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artistbandfacebook;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artistbandtwitter;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artistbandinstagram;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="logoartistband", cascade={"remove", "persist"})
     */
    private $artistbandlogo;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artistbandcountry;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artistbandcity;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artistbandcategory;
    /**
     * @ORM\OneToOne(targetEntity="Member", cascade={"persist"})
     */
    private $artistbandmember;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="pictureartistband", cascade={"remove", "persist"})
     */
    private $artistbandpicture;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", mappedBy="followartistband")
     */
    private $followedbymember;


    public function __construct()
    {
        $this->artistbandproject = new ArrayCollection();
        $this->artistbandpicture = new ArrayCollection();
        $this->artistbandlogo = new ArrayCollection();
        $this->followedbymember = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistbandName(): ?string
    {
        return $this->artistbandname;
    }

    public function setArtistbandName(string $artistbandname): self
    {
        $this->artistbandname = $artistbandname;

        return $this;
    }

    public function getArtistbandDescription(): ?string
    {
        return $this->artistbanddescription;
    }

    public function setArtistbandDescription(?string $artistbanddescription): self
    {
        $this->artistbanddescription = $artistbanddescription;

        return $this;
    }

    public function getArtistbandDateceation(): ?DateTimeInterface
    {
        return $this->artistbanddateceation;
    }

    public function setArtistbandDateceation(?DateTimeInterface $artistbanddateceation): self
    {
        $this->artistbanddateceation = $artistbanddateceation;

        return $this;
    }

    public function getArtistbandFacebook(): ?string
    {
        return $this->artistbandfacebook;
    }

    public function setArtistbandFacebook(?string $artistbandfacebook): self
    {
        $this->artistbandfacebook = $artistbandfacebook;

        return $this;
    }

    public function getArtistbandCountry(): ?string
    {
        return $this->artistbandcountry;
    }

    public function setArtistbandCountry(?string $artistbandcountry): self
    {
        $this->artistbandcountry = $artistbandcountry;

        return $this;
    }

    public function getArtistbandCity(): ?string
    {
        return $this->artistbandcity;
    }

    public function setArtistbandCity(?string $artistbandcity): self
    {
        $this->artistbandcity = $artistbandcity;

        return $this;
    }

    public function getArtistbandCategory(): ?string
    {
        return $this->artistbandcategory;
    }

    public function setArtistbandCategory(?string $artistbandcategory): self
    {
        $this->artistbandcategory = $artistbandcategory;

        return $this;
    }

    public function getArtistbandTwitter(): ?string
    {
        return $this->artistbandtwitter;
    }

    public function setArtistbandTwitter(?string $artistbandtwitter): self
    {
        $this->artistbandtwitter = $artistbandtwitter;

        return $this;
    }

    public function getArtistbandInstagram(): ?string
    {
        return $this->artistbandinstagram;
    }

    public function setArtistbandInstagram(?string $artistbandinstagram): self
    {
        $this->artistbandinstagram = $artistbandinstagram;

        return $this;
    }

    public function getArtistbandMember(): ?Member
    {
        return $this->artistbandmember;
    }

    public function setArtistbandMember(?Member $artistbandmember): self
    {
        $this->artistbandmember = $artistbandmember;

        return $this;
    }

    /**
     * @return Collection|PlaylistProject[]
     */
    public function getArtistbandProject(): Collection
    {
        return $this->artistbandproject;
    }

    public function addArtistbandProject(PlaylistProject $artistbandProject): self
    {
        if (!$this->artistbandproject->contains($artistbandProject)) {
            $this->artistbandproject[] = $artistbandProject;
            $artistbandProject->setArtistbandPlproject($this);
        }

        return $this;
    }

    public function removeArtistbandProject(PlaylistProject $artistbandProject): self
    {
        if ($this->artistbandproject->contains($artistbandProject)) {
            $this->artistbandproject->removeElement($artistbandProject);
            // set the owning side to null (unless already changed)
            if ($artistbandProject->getArtistbandPlproject() === $this) {
                $artistbandProject->setArtistbandPlproject(null);
            }
        }

        return $this;
    }

    public function getArtistbandPicture()
    {
        return $this->artistbandpicture;
    }

    public function addArtistbandPicture(Picture $artistbandPicture): self
    {
        if (!$this->artistbandpicture->contains($artistbandPicture)) {
            $this->artistbandpicture[] = $artistbandPicture;
            $artistbandPicture->setPictureArtistband($this);
        }

        return $this;
    }

    public function removeArtistbandPicture(Picture $artistbandPicture): self
    {
        if ($this->artistbandpicture->contains($artistbandPicture)) {
            $this->artistbandpicture->removeElement($artistbandPicture);
            // set the owning side to null (unless already changed)
            if ($artistbandPicture->getPictureArtistband() === $this) {
                $artistbandPicture->setPictureArtistband(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getArtistbandLogo(): Collection
    {
        return $this->artistbandlogo;
    }

    public function addArtistbandLogo(Picture $artistbandLogo): self
    {
        if (!$this->artistbandlogo->contains($artistbandLogo)) {
            $this->artistbandlogo[] = $artistbandLogo;
            $artistbandLogo->setLogoArtistband($this);
        }

        return $this;
    }

    public function removeArtistbandLogo(Picture $artistbandLogo): self
    {
        if ($this->artistbandlogo->contains($artistbandLogo)) {
            $this->artistbandlogo->removeElement($artistbandLogo);
            // set the owning side to null (unless already changed)
            if ($artistbandLogo->getLogoArtistband() === $this) {
                $artistbandLogo->setLogoArtistband(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getFollowedbymember(): Collection
    {
        return $this->followedbymember;
    }

    public function setFollowedbymember(?Member $followedbymember): self
    {
        $this->followedbymember = $followedbymember;

        return $this;
    }

    public function addFollowedbymember(Member $followedbymember): self
    {
        if (!$this->followedbymember->contains($followedbymember)) {
            $this->followedbymember[] = $followedbymember;
            $followedbymember->addFollowartistband($this);
        }

        return $this;
    }

    public function removeFollowedbymember(Member $followedbymember): self
    {
        if ($this->followedbymember->contains($followedbymember)) {
            $this->followedbymember->removeElement($followedbymember);
            $followedbymember->removeFollowartistband($this);
        }

        return $this;
    }

}
