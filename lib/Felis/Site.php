<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/13/2018
 * Time: 7:31 PM
 */

namespace Felis;


class Site{

    private $email = "";
    private $dbHost = null;     ///< Database host name
    private $dbUser = null;     ///<
    private $dbPassword = null;
    private $tablePrefix = '';
    private static $pdo = null; ///< The PDO object


    public function getTablePrefix()
    {
        return $this->tablePrefix;
    }
    private $root = '';

    public function getRoot()
    {
        return $this->root;
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function dbConfigure($host, $user, $password, $prefix){
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPassword = $password;
        $this->tablePrefix = $prefix;
    }

    /**
     * Database connection function
     * @returns PDO object that connects to the database
     */
    function pdo() {
        // This ensures we only create the PDO object once
        if(self::$pdo !== null) {
            return self::$pdo;
        }

        try {
            self::$pdo = new \PDO($this->dbHost,
                $this->dbUser,
                $this->dbPassword);
        } catch(\PDOException $e) {
            // If we can't connect we die!
            die("Unable to select database");
        }

        return self::$pdo;
    }


}