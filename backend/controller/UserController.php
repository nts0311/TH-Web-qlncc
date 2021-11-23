<?php

require("../dao/userdao.php");
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['func'] === 'register_user')
        registerUser();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
}

function registerUser()
{
    $user = new User();
    $user->setUsername($_POST["username"]);
    $user->setPassword(hash("sha256", $_POST["password"]));
    $user->setName($_POST["name"]);
    $user->setPhone($_POST["phone"]);
    $user->setEmail($_POST["email"]);
    $user->setAddress($_POST["address"]);

    $success = createUser($user);

    $result = [];
    if ($success === true)
        $result = ['error' => 0, 'msg' => 'Đăng ký thành công'];
    else
        $result = ['error' => -1, 'msg' => 'Lỗi đăng ký người dùng'];
    echo json_encode($result);
}
