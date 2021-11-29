<?php

require("dbconnector.php");
require("../model/order.php");

function getSuppliersTotalIncome()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $stats = [];
    $db = DbConnector::getInstance();
    $result = $db->query("SELECT s.id, s.name, s.category, SUM(o.unitPrice * o.quantity) AS totalPrice FROM ltweb.order AS o  INNER JOIN product AS p ON o.productId = p.id INNER JOIN supplier AS s ON p.supplierId = s.id GROUP BY s.name ORDER BY totalPrice DESC;    ");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $supplierId = $row['id'];
            $supplierName = $row['name'];
            $supplierCategory = $row['category'];
            $supplierIncome = $row['totalPrice'];
            $stat = ['id' => $supplierId, 'name' => $supplierName, 'category' => $supplierCategory, 'totalIncome' => $supplierIncome];

            array_push($stats, $stat);
        }
    }

    return $stats;
}

function getAllOrderForSupplier($supplierId)
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $orders = [];
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    $query = "SELECT * FROM user ltweb.order WHERE supplierId=?";
    $ps = $conn->prepare($query);

    $ps->bind_param("i", $supplierId);

    $ps->execute();

    $result = $ps->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $order = new Order();


            $order->setId($row['id']);
            $order->setProductId($row['productId']);
            $order->setUserId($row['userId']);
            $order->setQuantity($row['quantity']);
            $order->setUnitPrice($row['unitPrice']);
            $order->setOrderDate($row['orderDate']);

            array_push($orders, $order);
        }
    }

    return $orders;
}

function getProductStatByIncome($supplierId)
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $res = [];
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    $query = "SELECT p.name, SUM(o.unitPrice * o.quantity) as totalPrice "
        . "FROM ltweb.order AS o "
        . "INNER JOIN product AS p ON p.id = o.productId "
        . "INNER JOIN supplier AS s ON p.supplierID = s.id "
        . "WHERE s.id = ? GROUP BY p.id "
        . "HAVING totalPrice >= ALL("
        . "	SELECT SUM(o.unitPrice * o.quantity) FROM ltweb.order AS o "
        . "  INNER JOIN product AS p ON p.id = o.productId "
        . "  INNER JOIN supplier AS s ON p.supplierID = s.id "
        . "  WHERE s.id = ? GROUP BY p.id) OR "
        . "totalPrice <= ALL("
        . "	SELECT SUM(o.unitPrice * o.quantity) FROM ltweb.order AS o "
        . "    INNER JOIN product AS p ON p.id = o.productId "
        . "    INNER JOIN supplier AS s ON p.supplierID = s.id "
        . "    WHERE s.id = ? GROUP BY p.id) "
        . "ORDER BY totalPrice DESC;";

    $ps = $conn->prepare($query);
    $ps->bind_param("iii", $supplierId, $supplierId, $supplierId);

    $ps->execute();

    $result = $ps->get_result();

    $i=0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $res[$i++]=$row['name'];
        }
    }

    return $res;
}

function getProductStatByCount($supplierId)
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $res = [];
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    $query = "SELECT p.name, SUM(o.quantity) as totalCount "
        . "FROM ltweb.order AS o "
        . "INNER JOIN product AS p ON p.id = o.productId "
        . "INNER JOIN supplier AS s ON p.supplierID = s.id "
        . "WHERE s.id = ? GROUP BY p.id "
        . "HAVING totalCount >= ALL("
        . "	SELECT SUM(o.quantity) FROM ltweb.order AS o "
        . "  INNER JOIN product AS p ON p.id = o.productId "
        . "  INNER JOIN supplier AS s ON p.supplierID = s.id "
        . "  WHERE s.id = ? GROUP BY p.id) OR "
        . "totalCount <= ALL("
        . "	SELECT SUM(o.quantity) FROM ltweb.order AS o "
        . "    INNER JOIN product AS p ON p.id = o.productId "
        . "    INNER JOIN supplier AS s ON p.supplierID = s.id "
        . "    WHERE s.id = ? GROUP BY p.id) "
        . "ORDER BY totalCount DESC;";

    $ps = $conn->prepare($query);
    $ps->bind_param("iii", $supplierId, $supplierId, $supplierId);

    $ps->execute();

    $result = $ps->get_result();

    $i=0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $res[$i++]=$row['name'];
        }
    }

    return $res;
}

