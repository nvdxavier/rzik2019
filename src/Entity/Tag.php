<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tagname;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagname(): ?string
    {
        return $this->tagname;
    }

    public function setTagname(?string $tagname): self
    {
        $this->tagname = $tagname;

        return $this;
    }

}
