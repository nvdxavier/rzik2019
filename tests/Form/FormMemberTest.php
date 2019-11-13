<?php

namespace App\Tests\Form;

use App\Entity\Member;
use App\Form\MemberType;
use function array_keys;
use Symfony\Component\Form\Test\TypeTestCase;

class FormMemberTest extends TypeTestCase
{
    public function testValidPlaylistData(): void
    {
        $member = $this->createMember();
        $formData = [
            'firstname' => $member->getFirstname(),
            'lastname' => $member->getLastname(),
            'email' => $member->getEmail(),
            'password' => $member->getPassword()
        ];

        $objectToCompare = new Member();

        $form = $this->factory->create(MemberType::class, $objectToCompare);
        $form->submit($formData);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
        $this->assertTrue($form->isSynchronized());
    }

    private function createMember(): Member
    {
        $member = new Member();
        $member->setPassword('userdemo');
        $member->setFirstname('Xavier');
        $member->setLastname('NVD');
        $member->setEmail('nostromo@caramil.com');

        return $member;
    }
}
