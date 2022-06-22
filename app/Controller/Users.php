<?php

namespace SebDru\Blog\Controller;

use Exception;
use SebDru\Blog\Model;
use SebDru\Blog\Model\User;
use SebDru\Blog\Model\UserManager;
use SebDru\Blog\Controller\ValidatorUser;

class Users extends Controller
{
    public function connect(string $name, string $password)
    {
        $checkLogin = new Model\UserManager();
        $user = $checkLogin->getUserbyName($name);

        if (false == $user) {
            throw new Exception("Le nom d'utilisateur n'a pas été trouvé");
        } elseif ($user->getStatus() === "banned") {
            throw new Exception("Ce compte a été banni");
        }

        $checkPassword = $checkLogin->checkPassword($user->getId(), $password);

        if (true == $checkPassword) {
            $_SESSION = ['userInformation' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'status' => $user->getStatus(),
            ]];

            if ($_SESSION['userInformation']['status'] === "admin") {
                isset($articlesController) ? null : $articlesController = new Articles();
                $articlesController->editListArticles($_SESSION);
            } else {
                $this->twig->display('frontOffice/index.html.twig', ['session' => $_SESSION]);
            }
        } else {
            $this->twig->display('frontOffice/login.html.twig', compact('name'));
        }
    }

    public function disconnect()
    {
        unset($_SESSION['userInformation']);
        session_destroy();
        $this->twig->display('frontOffice/index.html.twig', ['session' => $_SESSION]);
    }

    public function editListUsers()
    {
        $userManager = new Model\UserManager();
        $users = $userManager->getUsers();
        $this->twig->display('backOffice/adminUsers.html.twig', compact('users'));
    }

    public function addUser(array $newUser)
    {
        try {
            $user = new Model\User();
            $user->setName($newUser['name'])
                ->setEmail($newUser['email'])
                ->setPassword($newUser['password'])
                ->setPasswordConfirm($newUser['passwordConfirm'])
                ->setStatus('waitingForValidation');

            $ValidatorUser = new ValidatorUser();
            $user = $ValidatorUser->validatorName($user);
            $user = $ValidatorUser->validatorEmail($user);
            $user = $ValidatorUser->validatorPassword($user);

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

    public function updateUser(array $get)
    {
        switch ($get["action"]) {
            case 'ValidateUser':
                $status = "user";
                break;
            case 'banishUser':
                $status = "banned";
                break;
        }

        $user = new Model\User();
        $user
            ->setId($get['id'])
            ->setStatus($status);

        $UserManager = new Model\UserManager();
        $UserManager->updateStatus($user);

        header('Location: index.php?action=editListUsers');
    }
}
