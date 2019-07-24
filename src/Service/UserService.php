<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserService extends AbstractController
{

    /**
     * @param array $roleArray
     * @param string $role
     * @param string $redirect
     * @param string $elseredirect
     * @return RedirectResponse
     */
    public function redirectByRole(string $role, array $roleArray, string $redirect, string $elseredirect)
    {
        if (in_array($role, $roleArray) === true) {

            return $this->redirect($redirect);
        } else {

            return $this->redirect($elseredirect);
        }
    }
}