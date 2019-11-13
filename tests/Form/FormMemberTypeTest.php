<?php

namespace App\Tests;


use App\Entity\Member;
use App\Form\MemberType;
use function array_keys;
use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class FormMemberTypeTest extends TypeTestCase
{

    public function testSubmitValidData(): void
    {
        $member = $this->createMember();
        $formMember = [
            'firstname' => $member->getFirstname(),
            'lastname' => $member->getLastname(),
            'email' => $member->getEmail(),
            'password' => $member->getPassword(),
            'role' => $member->getRoles()
        ];

        $objectToCompare = new Member();

        $form = $this->factory->create(MemberType::class, $objectToCompare);
        $form->submit($formMember);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($member, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formMember) as $key) {
            $this->assertArrayHasKey($key, $formMember);
        }
    }

    private function createMember()
    {
        $member = new Member();
        $member->setemail('kamouloxx@itineris.fr');
        $member->setpassword('chocapic');
        $member->setfirstname('kalogero');
        $member->setlastname('kanon');

        return $member;
    }
}
