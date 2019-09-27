<?php

namespace App\DataFixtures\ORM;

use function array_keys;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractAliceFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordencoder)
    {
        $this->passwordEncoder = $passwordencoder;
    }

    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $objects = [];

        foreach ($this->getFixturesFiles() as $fixturesFile) {
            $objects = $loader->loadFile(
                $fixturesFile
            )->getObjects();
        }

        foreach ($objects as $name => $object) {
            if (method_exists($object, 'getPassword')) {
                $object->setPassword($this->passwordEncoder->encodePassword($object,
                    $object->getPassword())
                );
            }
            if (!$this->hasReference($name)) {
                $manager->persist($object);
            }
        }
        $manager->flush();

        foreach ($objects as $name => $object) {
            if (!$this->hasReference($name)) {
                $this->setReference($name, $object);
            }
        }
    }

    abstract protected function getFixturesFiles(): array;

    protected function getReferences(): array
    {
        $references = [];
        $keys = array_keys($this->referenceRepository->getReferences());

        foreach ($keys as $key) {
            $references[$key] = $this->getReference($key);
        }

        return $references;
    }
}
