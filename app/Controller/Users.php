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

            if (false == $user) {
                throw new Exception("Le nom d'utilisateur n'a pas été trouvé");
            }

            $checkPassword = $checkLogin->checkPassword($user->getId(), $password);

            if (true == $checkPassword) {
                $_SESSION = ['userInformation' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'admin' => $user->getAdmin(),
                ]];

                if ($_SESSION['userInformation']['admin'] == 1) {
                    isset($articleController) ? null : $articlesController = new Articles();
                    $arg = $articlesController->editListArticles($_SESSION);
                } else {
                    $this->twig->display('frontOffice/index.html.twig', ['session' => $_SESSION]);
                }
            } else {
                $this->twig->display('frontOffice/login.html.twig', compact('name'));
            }
        } catch (Exception $exception) {
            $errors['password'] = $exception->getMessage();
        }
    }

    public function disconnect()
    {
        unset($_SESSION['userInformation']);
        session_destroy();
        $this->twig->display('frontOffice/index.html.twig', ['session' => $_SESSION]);
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
            $this->twig->display('frontOffice/register.html.twig', compact('errors'));
        }

        $creationSuccess = true;
        $name = $user->getName();
        $this->twig->display('frontOffice/login.html.twig', compact('name', 'creationSuccess'));
    }
}
