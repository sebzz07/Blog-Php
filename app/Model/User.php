<?php

namespace SebDru\Blog\Model;

use Exception;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private bool $admin;


    public function __construct( int $id, string $name, string $email, string $password, bool $admin)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
    }

    /**
     * Setter of name
     *
     * @param string $name
     * @return ?bool
     */
    public function setName( string $name ): ?bool
    {
        if (isset($name) && strlen($name) >=6 && strlen($name) <=25 && preg_match('/^[a-zA-Z0-9_]+$/', $name)) 
        {
            $this->name = $name;
            return true;
        } else
        {
            throw New Exception("Must be between 8 and 128 characters with only alphabet, number and underscore");
        }
        
    }
    /**
     * Setter of email
     *
     * @param string $email
     * @return ?bool
     */
    public function setEmail(string $email) : ?bool
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL ) !== null ) {
                    $this->email = $email;
                    return true;

            } else
            {
                throw New Exception ("incorrect email or missing");
            }
    }

    /**
     * Setter of password
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        if (preg_match('/(?=.*[0-9])/' , $password )) 
        {
            throw New Exception ("A number must appear at least once");
        }
        elseif (preg_match('/(?=.*[a-z])/' , $password ))
        {
            throw New Exception ("A lowercase alphabet must appear at least once");
        }
        elseif (preg_match('/(?=.*[A-Z])/' , $password ))
        {
            throw New Exception ("An uppercase alphabet that appears at least once.");
        }
        elseif (preg_match('/(?=.*[@#$%^&-+=() ])/' , $password ))
        {
            throw New Exception ("A special character must appear at least once");
        }
        elseif (preg_match('/(?=\\S+$)/' , $password ))
        {
            throw New Exception ("white spaces are not allowed");
        }
        elseif ( strlen( $password ) >=8 || strlen( $password ) <= 128 )
        {
            throw New Exception ("Must be between 8 and 128 characters");
        }
        else {
            
            $this->password = $password;
        }

        
    }

    /**
     * Getter of id
     *
     * @return integer
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Getter of name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Getter of email
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

}