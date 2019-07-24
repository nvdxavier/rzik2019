<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member implements UserInterface
{
    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstname;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastname;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="member", cascade={"remove", "persist"})
     */
    private $article;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="memberowner", cascade={"remove", "persist"})
     */
    private $memberpicture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArtistBand", mappedBy="followedbymember", cascade={"remove", "persist"})
     */
    private $followartistband;


    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->memberpicture = new ArrayCollection();
        $this->followartistband = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }


    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setMember($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getMember() === $this) {
                $article->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getMemberpicture(): Collection
    {
        return $this->memberpicture;
    }

    public function addMemberpicture(Picture $memberpicture): self
    {
        if (!$this->memberpicture->contains($memberpicture)) {
            $this->memberpicture[] = $memberpicture;
            $memberpicture->setMemberOwner($this);
        }

        return $this;
    }

    public function removeMemberpicture(Picture $memberpicture): self
    {
        if ($this->memberpicture->contains($memberpicture)) {
            $this->memberpicture->removeElement($memberpicture);
            // set the owning side to null (unless already changed)
            if ($memberpicture->getMemberOwner() === $this) {
                $memberpicture->setMemberOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArtistBand[]
     */
    public function getFollowartistband(): Collection
    {
        return $this->followartistband;
    }

    public function addFollowartistband(ArtistBand $followartistband): self
    {
        if (!$this->followartistband->contains($followartistband)) {
            $this->followartistband[] = $followartistband;
            $followartistband->setFollowedbymember($this);
        }

        return $this;
    }

    public function removeFollowartistband(ArtistBand $followartistband): self
    {
        if ($this->followartistband->contains($followartistband)) {
            $this->followartistband->removeElement($followartistband);
            // set the owning side to null (unless already changed)
            if ($followartistband->getFollowedbymember() === $this) {
                $followartistband->setFollowedbymember(null);
            }
        }

        return $this;
    }
}
