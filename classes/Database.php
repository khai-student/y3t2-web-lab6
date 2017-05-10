<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2017
 * Time: 20:50
 */
class Database
{
    private $mysqli = null;
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "mysql";
    private $db_user = "root";
    private $password = "root";

    public function __construct($host = "", $port = "", $db_name = "", $db_user = "", $password = "")
    {
        $this->host = ($host != "") ? $host : $this->host;
        $this->port = ($port != "") ? $port : $this->port;
        $this->db_name = ($db_name != "") ? $db_name : $this->db_name;
        $this->db_user = ($db_user != "") ? $db_user : $this->db_user;
        $this->password = ($password != "") ? $password : $this->password;

        $this->Connect();
    }

    public function __destruct()
    {
        $this->Disconnect();
    }

    private function Connect() {
        $this->mysqli = new mysqli($this->host.':'.$this->port, $this->db_user, $this->password, $this->db_name);
        if ($this->mysqli->connect_error)
        {
            Debug::Error('Error : ('. $this->mysqli->connect_errno .') '. $this->mysqli->connect_error);
        }
    }

    private function Disconnect() {
        $this->mysqli->close();
    }

//  BL methods.
    public function Select($sql) {
        $result = null;

        $result = $this->mysqli->query($sql);
        if ($result) {
            $array = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            return $array;
        }
        else {
            return null;
        }
    }

    public function Insert($sql) {
        return $this->mysqli->query($sql);
    }

    public function RealEscapeString($string) {
        if ($this->mysqli == null)
        {
            return '';
        }
        $string = $this->mysqli->real_escape_string($string);
        return $string;
    }
}