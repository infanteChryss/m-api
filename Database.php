<?php

    class Database {

        // DB Params
        private $host = 'localhost';
        private $dbname = 'geometer_v1';
        private $username = 'root';
        private $password = '';
        private $conn;

        // DB Connect
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host. ';dbname=' . $this->dbname, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            } catch (PDOException $e) {
                return false; 
            }
            
            return $this->conn;
        }

    }