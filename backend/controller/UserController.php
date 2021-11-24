<?php

require("../dao/userdao.php");
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);

session_start();

$func = $_POST['func'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($func === 'register_user') {
        registerUser();
    } else if ($func === 'login_user') {
        loginUser();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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

function loginUser()
{
    $user = getUserByUsername($_POST['username']);

    $result = ['error' => 0, 'msg' => 'Đăng nhập thành công'];

    if (is_null($user)) {
        $result = ['error' => 1, 'msg' => 'Tên đăng nhập không tồn tại'];
        echo json_encode($result);
        return;
    }

    if ($user->getPassword() != hash("sha256", $_POST['password']))
    {
        $result = ['error' => 2, 'msg' => 'Sai mật khẩu'];
        echo json_encode($result);
        return;
    } 


    $_SESSION['user_loggedin']=true;
    $_SESSION['user_id']=$user->getId();
    $_SESSION['user_pos']=$user->getPosition();
    $_SESSION['user_data']=json_encode($user);

    echo json_encode($result);
}
