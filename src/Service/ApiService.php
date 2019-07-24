<?php

namespace App\Service;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

final class ApiService
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * PostService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $message
     * @return Tag
     */
    public function createTag(string $tag): Tag
    {
        $postTag = new Tag();
        $postTag->setTagname($tag);
        $this->em->persist($postTag);
        $this->em->flush();

        return $postTag;
    }

    /**
     * @return object[]
     */
    public function getAll(): array
    {
        return $this->em->getRepository(Tag::class)->findBy([], ['id' => 'DESC']);
    }
}