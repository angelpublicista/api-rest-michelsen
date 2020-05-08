<?php

//CONEXIÓN ODBC
class db{
    private $dbFile = 'C:\xampp\htdocs\conexion-odbc\michelsen_2020.accdb';

    public function connectDB(){
        // Connection to ms access
        $conn = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=".$this->dbFile.";Uid=;Pwd=;charset=UTF-8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conn;
    }

}

// CONEXIÓN MYSQL
// class db{
//     private $dbHost = "localhost";
//     private $dbUser = "root";
//     private $dbPass = "";
//     private $dbName = "test_michelsen";

//     //Conexión
//     public function connectDB(){
//         $arrOptions = array(
//             PDO::ATTR_EMULATE_PREPARES => FALSE, 
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
//             PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
//         );

//         $mysqlConnect = "mysql:host=$this->dbHost;dbName=$this->dbName;charset=utf8";
//         $dbConection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass, $arrOptions);
//         // $dbConection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         return $dbConection;
//     }
// }

