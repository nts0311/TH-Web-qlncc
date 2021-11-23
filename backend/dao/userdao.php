<?php

require("dbconnector.php");
require("../model/user.php");

function createUser(User $user)
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    if ($conn->connect_errno) {
        return false;
    }

    try {
        $query = "INSERT INTO user (username, password, name, phone, email, address) VALUES (?,?,?,?,?,?)";
        $ps = $conn->prepare($query);

        // $username=$user->getUsername();
        // $password=$user->getPassword();
        // $name=$user->getName();
        // $phone=$user->getPhone();
        // $email=$user->getEmail();
        // $address=$user->getAddress();


        $ps->bind_param("ssssss", $user->getUsername(), $user->getPassword(), $user->getName(), $user->getPhone(), $user->getEmail(), $user->getAddress());
        //$ps->bind_param("ssssss", $username,$password,$name,$phone,$email,$address);

        return $ps->execute();

        //return $ps->affected_rows != -1;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        exit();
    }
}

function getUserByUsername(string $username)
{
}
