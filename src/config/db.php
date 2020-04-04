<?php

class db{
    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "test_michelsen";

    //Conexión
    public function connectDB(){
        $mysqlConnect = "mysql:host=$this->dbHost;dbName=$this->dbName;charset=utf8";
        $dbConection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
        $dbConection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConection;
    }
}

/*Pruebas*/
/*
private $dbHost = "localhost";
private $dbUser = "univerci_michelsen";
private $dbPass = "suCY9ogyNDED";
private $dbName = "univerci_api_michelsen";
*/

/*Local*/
/*
private $dbHost = "localhost";
private $dbUser = "root";
private $dbPass = "";
private $dbName = "test_michelsen";
*/