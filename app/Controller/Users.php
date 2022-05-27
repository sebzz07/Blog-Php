<?php

namespace SebDru\Blog\Controller;

use Exception;
use SebDru\Blog\Model;
use SebDru\Blog\Controller\ValidatorForm;

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
        try {
            $user = new Model\User();
            $user->setName(htmlspecialchars($newUser['name']))
                ->setEmail(htmlspecialchars($newUser['email']))
                ->setPassword($newUser['password'])
                ->setPasswordConfirm($newUser['passwordConfirm']);

            $validatorForm = new ValidatorForm();
            $user = $validatorForm->validatorName($user);
            $user = $validatorForm->validatorEmail($user);
            $user = $validatorForm->validatorPassword($user);

            $user->CryptPassword();

            $userManager = new Model\UserManager();
            $user = $userManager->RegisterUser($user);
        } catch (Exception $exception) {
            $errors['password'] = $exception->getMessage();
            $this->twig->display('frontend/register.html.twig', compact('errors'));
        }

        $creationSuccess = true;
        $name = $user->getName();
        $this->twig->display('frontend/login.html.twig', compact("name", "creationSuccess"));
    }
}
