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

    public function __construct()
    {
        $this->Connect();
    }

    public function __destruct()
    {
        try
        {
            $this->Disconnect();
        }
        catch (Exception $e)
        {
            die();
        }
    }

    private function Connect() {
        $this->mysqli = new mysqli(DB_HOST.':'.DB_PORT, DB_USERNAME, DB_PASSWORD, DB_DBNAME);
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