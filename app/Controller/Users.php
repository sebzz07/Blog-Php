<?php

namespace SebDru\Blog\Controller;

use Exception;
use SebDru\Blog\Model;

class Users extends Controller
{
    public function connect(string $name, string $password)
    {
        try {
            $checkLogin = new Model\UserManager();
            $user = $checkLogin->getUserbyName($name);

            if ($user == false) {
                throw new Exception("Le nom d'utilisateur n'a pas été trouvé");
            }

            $checkPassword = $checkLogin->checkPassword($user->getId(), $password);

            if ($checkPassword == true) {
                $_SESSION = ['userInformation' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
            ]];

                $this->twig->display('frontend/landing.html.twig', ['session' => $_SESSION]);
            } else {
                $this->twig->display('frontend/login.html.twig', compact('name'));
            }
        } catch (Exception $exception) {
            $errors['password'] = $exception->getMessage();
        }
    }

    public function disconnect()
    {
        unset($_SESSION['userInformation']);
        session_destroy();
        $this->twig->display('frontend/landing.html.twig', ['session' => $_SESSION]);
    }

    public function addUser(array $newUser)
    {
        $userManager = new Model\UserManager();

        try {
            $user = new Model\User();

            $user->setName($newUser['name'])
            ->setEmail($newUser['email'])
            ->setNewPassword($newUser['password'], $newUser['passwordConfirm']);

            $addUser = $userManager->RegisterUser($user);
            $creationSuccess = true;
        } catch (Exception $exception) {
            $errors['password'] = $exception->getMessage();
        }

        $this->twig->display('frontend/login.html.twig', compact('name', 'creationSuccess'));

        $this->twig->display('frontend/register.html.twig', compact('errors'));
    }
}
