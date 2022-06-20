<?php

namespace SebDru\Blog\Model;

use Exception;

class User
{
    private int $id = 0;
    private string $name = "";
    private string $email = "";
    private string $password = "";
    private string $passwordConfirm = "";
    private string $status = "waitingForValidation";

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }



    /**
     * Setter of name.
     * 
     * @return self
     * @param string $name
     */
    public function setName(string $name): self
    {
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


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    public function CryptPassword(): self
    {
        if ($this->password == "" || $this->passwordConfirm == "") {
            throw new \Exception('impossible to crypt password, missing data');
        }
        if ($this->password != $this->passwordConfirm) {
            throw new \Exception('impossible to crypt password, no corresponding between password and password Confirmation');
        }
        $this->setPasswordConfirm("");
        $this->setPassword(password_hash($this->password, PASSWORD_BCRYPT, ['cost' => '10']));
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
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

    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
