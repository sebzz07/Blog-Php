<?php

namespace SebDru\Blog\Model;

use Exception;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function setId(string $id) : self
    {
            $this->id = $id;
            return $this;
    }
    /**
     * Setter of name.
     */
    public function setName(string $name): self
    {
        if (!isset($name)) {
            throw new Exception('Vous devez saisir un nom');
        }

        if (strlen($name) <= 6 && strlen($name) >= 50 && !preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
            throw new Exception("le nom n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _) et doit avoir entre 6 et 50 caratères");
        }


        $this->name = $name;

        return $this;
    }

    /**
     * Setter of email.
     */
    public function setEmail(string $email): self
    {
        

        $this->email = $email;

        return $this;
    }
    public function setPassword(string $password) : self {
        $this->password = $password;

        return $this;
    }

    /**
     * Setter of password.
     */
    public function setNewPassword(string $password, string $password_confirm): self
    {
        if (empty($password)) {
            throw new Exception('il manque un mot de passe');
        }
        if (!preg_match('/(?=.*[0-9])/', $password)) {
            throw new Exception('Un chiffre doit être utilisé au moins une fois dans le mot de passe.');
        }
        if (!preg_match('/(?=.*[a-z])/', $password)) {
            throw new Exception('Une minuscule doit être utilisée au moins une fois dans le mot de passe.');
        }
        if (!preg_match('/(?=.*[A-Z])/', $password)) {
            throw new Exception('Une majuscule doit être utilisée au moins une fois dans le mot de passe.');
        }
        if (!preg_match('/(?=.*[@#$%^&-+=() ])/', $password)) {
            throw new Exception('Un charatère spécial : @ # $ % ^ & - + = ( ) doit être utilisé au moins une fois dans le mot de passe.');
        }
        if (preg_match('/(?=\\s+)/', $password)) {
            throw new Exception("Le mot de passe ne doit pas contenir d'espace.");
        }
        if (strlen($password) < 8) {
            throw new Exception('Le mot de passe doit avoir au moins 8 caractères.');
        }
        if (strlen($password) >= 128) {
            throw new Exception('Le mot de passe doit avoir moins de 128 caractères.');
        }
        if (empty($password_confirm || $password != $password_confirm)) {
            throw new Exception('Les deux mots de passe ne sont pas identiques');
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => '10']);

        return $this;
    }

    /**
     * Getter of id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Getter of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Getter of email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
