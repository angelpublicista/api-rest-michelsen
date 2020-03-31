<?php

class db{
    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "test_michelsen";

    //Conexión
    public function connectDB(){
        $mysqlConnect = "mysql:host=$this->dbHost;dbName=$this->dbName";
        $dbConection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
        $dbConection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConection;
    }
}