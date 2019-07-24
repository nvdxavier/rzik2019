<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MusicFileRepository")
 * @ORM\Table(name="musicfile")
 */
class MusicFile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\File(
     *     maxSize = "15M",
     *     mimeTypes = {"audio/mpeg"},
     *     mimeTypesMessage = "Veuillez ajouter un type de fichier valide"
     * )
     * @ORM\Column(type="string")
     */
    private $filename;

    /**
     * @Assert\DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $filedate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filetitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileartist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filecategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileposition;

    /**
     * @ORM\Column(type="integer", type="integer", nullable=true)
     */
    private $fileduration;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $filetransfertdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlaylistProject", inversedBy="musicfileplproject")
     */
    private $playlistproject;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFiledate(): ?DateTimeInterface
    {
        return $this->filedate;
    }

    public function setFiledate(DateTimeInterface $filedate): self
    {
        $this->filedate = $filedate;

        return $this;
    }


    public function getFiletitle(): ?string
    {
        return $this->filetitle;
    }

    public function setFiletitle(string $filetitle): self
    {
        $this->filetitle = $filetitle;

        return $this;
    }

    public function getFileartist(): ?string
    {
        return $this->fileartist;
    }

    public function setFileartist(?string $fileartist): self
    {
        $this->fileartist = $fileartist;

        return $this;
    }


    public function getFilecategory(): ?string
    {
        return $this->filecategory;
    }

    public function setFilecategory(?string $filecategory): self
    {
        $this->filecategory = $filecategory;

        return $this;
    }

    public function getFileposition(): ?string
    {
        return $this->fileposition;
    }

    public function setFileposition(?string $fileposition): self
    {
        $this->fileposition = $fileposition;

        return $this;
    }


    public function setDuration(?int $fileduration): self
    {
        $this->fileduration = $fileduration;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->fileduration;
    }

    public function getFileduration(): ?int
    {
        return $this->fileduration;
    }

    public function setFileduration(?int $fileduration): self
    {
        $this->fileduration = $fileduration;

        return $this;
    }

    public function getFiletransfertdate(): ?DateTimeInterface
    {
        return $this->filetransfertdate;
    }

    public function setFiletransfertdate(?DateTimeInterface $filetransfertdate): self
    {
        $this->filetransfertdate = $filetransfertdate;

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
