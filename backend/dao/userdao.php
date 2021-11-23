<?php

require("dbconnector.php");
require("../model/user.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function createUser(User $user)
{
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    if ($conn->connect_errno) {
        return false;
    }

    try {
        $query = "INSERT INTO user (username, password, name, phone, email, address) VALUES (?,?,?,?,?,?)";
        $ps = $conn->prepare($query);

        $ps->bind_param("ssssss", $user->getUsername(), $user->getPassword(), $user->getName(), $user->getPhone(), $user->getEmail(), $user->getAddress());

        return $ps->execute();
    } catch (Exception $e) {
        return false;
    }
}

function getUserByUsername(string $username)
{
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $query = "SELECT * FROM user WHERE username=?";
        $ps = $conn->prepare($query);

        $ps->bind_param("s", $username);

        $ps->execute();

        $result = $ps->get_result();

        if($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
            $user = new User();

            $user->setId($data['id']);
            $user->setUsername($data['username']);
            $user->setPassword($data['password']);
            $user->setName($data['name']);
            $user->setPhone($data['phone']);
            $user->setEmail($data['email']);
            $user->setAddress($data['address']);
            $user->setPosition($data['position']);

            return $user;
        }

        return NULL;

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        return NULL;
    }
}
