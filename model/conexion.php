<?php

class Conexion
{
    public static function getconect()
    {
        $host = "localhost";
        $dbName = "admin";
        $user = "root";
        $password = "";
        
        try {
            return new PDO("mysql:host={$host};dbname={$dbName}", "{$user}", "{$password}");
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}