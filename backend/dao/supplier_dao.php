<?php

require("dbconnector.php");
require("../model/supplier.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function getAllSupplier()
{
    $suppliers = [];
    $db = DbConnector::getInstance();
    $result = $db->query("SELECT * FROM supplier");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $supp = new Supplier();
            $supp->setId($row['id']);
            $supp->setName($row['name']);
            $supp->setCategory($row['category']);
            $supp->setPhone($row['phone']);
            $supp->setEmail($row['email']);
            $supp->setAddress($row['address']);
            $supp->setAccountId($row['accountId']);

            array_push($suppliers, $supp);
        }
    }

    return $suppliers;
}

function insertSupplier(Supplier $supplier)
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = DbConnector::getInstance();
    $conn = $db->getConnection();

    try {
        $query = "INSERT INTO supplier (name, category, phone, email, address) VALUES (?,?,?,?,?)";
        $ps = $conn->prepare($query);

        $ps->bind_param(
            "sssss",
            $supplier->getName(),
            $supplier->getCategory(),
            $supplier->getPhone(),
            $supplier->getEmail(),
            $supplier->getAddress()
        );

        $result = $ps->execute();

        if ($result === TRUE)
            return $ps->insert_id;
        else return -1;
    } catch (Exception $e) {
        return -1;
    }
}

function deleteSupplier($supplierId)
{
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = DbConnector::getInstance();
        $conn = $db->getConnection();

        $query = "DELETE FROM supplier WHERE id=?";
        $ps = $conn->prepare($query);

        $ps->bind_param("i", $supplierId);

        return $ps->execute();
    } catch (Exception $e) {
        return false;
    }
}

function updateSupplier(Supplier $supplier)
{
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = DbConnector::getInstance();
        $conn = $db->getConnection();

        $query = "UPDATE supplier SET name=?, category=?, phone=?, email=?, address=? WHERE id=?";
        $ps = $conn->prepare($query);

        $ps->bind_param(
            "sssssi",
            $supplier->getName(),
            $supplier->getCategory(),
            $supplier->getPhone(),
            $supplier->getEmail(),
            $supplier->getAddress(),
            $supplier->getId()
        );

        return $ps->execute();
    } catch (Exception $e) {
        return false;
    }
}
