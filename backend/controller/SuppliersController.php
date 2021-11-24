<?php

require("../dao/supplier_dao.php");

error_reporting(E_ERROR | E_PARSE);

session_start();
header('Content-Type: application/json');

$func = $_POST['func'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_SESSION['user_loggedin']===FALSE || ($_SESSION['user_pos'] != 'admin')) {
        $response = ['error' => 1, 'msg' => "Bạn cần đăng nhập với quyền quản trị"];
        echo json_encode($response);
        die();
    }

    if ($func === 'create_supplier') {
        createSupplier();
    } else if ($func === 'get_suppliers') {
        getSupplier();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
}

function createSupplier()
{
    $supplier = new Supplier();
    $supplier->setName($_POST['name']);
    $supplier->setCategory($_POST['category']);
    $supplier->setPhone($_POST['phone']);
    $supplier->setEmail($_POST['email']);
    $supplier->setAddress($_POST['address']);

    $supplierId=insertSupplier($supplier);
    
    $response=[];

    if($supplierId != -1)
        $response = ['supplierId'=>$supplierId, 'msg'=>'Thêm nhà cung cấp thành công.'];
    else 
    $response = ['error'=>1, 'msg'=>'Lỗi thêm nhà cung cấp.'];

    
    echo json_encode($response);
}

function getSupplier()
{
    $suppliers = getAllSupplier();
    $response = [];

    foreach ($suppliers as $supp) {
        $obj = [
            'id' => $supp->getId(),
            'name' => $supp->getName(),
            'category' => $supp->getCategory(),
            'phone' => $supp->getPhone(),
            'email' => $supp->getEmail(),
            'address' => $supp->getAddress(),
            'accountId' => $supp->getAccountId()
        ];

        array_push($response, $obj);
    }

    // $obj = [
    //     'id' => "asdf",
    //     'name' => "asdf",
    //     'category' => "asdf",
    //     'phone' => "asdf",
    //     'email' => "asdf",
    //     'address' => "asdf",
    //     'accountId' => 1
    // ];

    // array_push($response, $obj);
    // array_push($response, $obj);

    echo json_encode($response);
}
