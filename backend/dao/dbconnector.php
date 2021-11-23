<?php
$servername = "localhost";
$username = "root";
$password = "3112000";
$schemaName = "ltweb";


class DbConnector
{
    private static $conn = NULL;

    private function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "3112000";
        $schemaName = "ltweb";

        $this->conn = new mysqli($servername, $username, $password, $schemaName);
    }

    public function getConnection()
    {
        return $this->conn;
    }

    function dbquery($sql)
    {
        global $conn;
        return mysqli_query($conn, $sql);
    }

    private static $instance = NULL;
    public static function getInstance()
    {
        if (is_null(DbConnector::$instance))
            DbConnector::$instance = new DbConnector();
        return DbConnector::$instance;
    }
}
