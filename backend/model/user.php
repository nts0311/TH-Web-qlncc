<?php

Class User{
    private $id;
    private $username;
    private $password;
    private $name;
    private $phone;
    private $email;
    private $address;

    // public function __construct($username, $password, $name, $phone,$email,$address)
    // {

    //     $this->$username = $username;
    //     $this->$password = $password;
    //     $this->$name = $name;
    //     $this->$phone = $phone;
    //     $this->$email = $email;
    //     $this->$address = $address;
    // }

    public function __construct()
    {
        
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}