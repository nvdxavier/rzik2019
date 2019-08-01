<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $role = [["ROLE_ARTIST"], ["ROLE_USER"]];
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new Member();
            $user->setLastname($faker->name);
            $user->setFirstname($faker->firstName);
            $user->setEmail(sprintf('userdemo%d@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'userdemo'
            ));

            $key = array_rand($role);
            $user->setRoles($role[$key]);
            $manager->persist($user);
        }

        $manager->flush();

    }
}
