<?php

require("../dao/order_dao.php");

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

    if ($func === 'get_suppliers_stat') {
        getSuppliersStats();
    } 
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
}

function getSuppliersStats()
{
    $supplierStats = [];

    $incomeStat = getSuppliersTotalIncome();

    foreach($incomeStat as $stat)
    {
        $countStat= getProductStatByCount($stat['id']);
        $incomeStat= getProductStatByIncome($stat['id']);

        $supplierStat=['name'=>$stat['name'], 'category'=>$stat['category'], 'totalIncome'=>$stat['totalIncome'], 'sp1'=>'','sp2'=>'','sp3'=>'','sp4'=>''];
        if(count($countStat)==2)
        {
            $supplierStat['sp1'] = $countStat[0];
            $supplierStat['sp2'] = $countStat[1];
        }
        else if(count($countStat)==1)
        {
            $supplierStat['sp1'] = $countStat[0];
        }

        if(count($incomeStat)==2)
        {
            $supplierStat['sp3'] = $incomeStat[0];
            $supplierStat['sp4'] = $incomeStat[1];
        }
        else if(count($incomeStat)==1)
        {
            $supplierStat['sp3'] = $incomeStat[0];
        }

        array_push($supplierStats, $supplierStat);
    }

    echo json_encode($supplierStats);
}

