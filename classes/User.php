<?php

    class User {

        // DB stuff
        private $conn;
        private $table = 'users';


        // User Properties
        public $user_id;
        public $first_name;
        public $middle_name;
        public $last_name;
        public $email;
        public $username;
        public $password;
        public $role;
        public $role_id;
        public $status;
        
        public $error_info;

        // constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        // Get Users
        public function read($query_type) {

            if ($query_type == "all") {
                // Create query
                $query = 'SELECT
                            u.*,
                            r.name AS role
                        FROM
                            ' .$this->table. ' u
                        JOIN
                            roles r ON r.role_id = u.role_id
                        ORDER BY
                            u.last_name DESC';
                
                // Prepare statement
                $stmt = $this->conn->prepare($query);
                // Execute Query
                if ($stmt->execute()) {
                    return $stmt;
                } 
                return false;
            } else {
                // Create query
                $query = 'SELECT
                            u.*,
                            r.name AS role
                        FROM
                            ' .$this->table. ' u
                        JOIN
                            roles r ON r.role_id = u.role_id
                        WHERE 
                            u.user_id = ?
                        LIMIT 0,1';
                
                // Prepare statement
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(1, $this->user_id);

                if($stmt->execute()) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
                return null;
            }
        }

        // Create User
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table .
                    ' SET
                        first_name = :first_name,
                        middle_name = :middle_name,
                        last_name = :last_name,
                        email = :email,
                        username = :username,
                        password = :password,
                        role_id = :role_id,
                        status = :status';
  
            // Prepare statement
            $stmt = $this->conn->prepare($query);
  
            // Clean data
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->role_id = htmlspecialchars(strip_tags($this->role_id));
            $this->status = htmlspecialchars(strip_tags($this->status));
  
            // Bind data
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':middle_name', $this->middle_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role_id', $this->role_id);
            $stmt->bindParam(':status', $this->status);
  
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            $this->error_info = $stmt->errorInfo();

            return false;
        }

        // Update User
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . 
                        ' SET
                            first_name = :first_name,
                            middle_name = :middle_name,
                            last_name = :last_name,
                            email = :email,
                            username = :username,
                            password = :password,
                            role_id = :role_id,
                            status = :status
                        WHERE user_id = :user_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->role_id = htmlspecialchars(strip_tags($this->role_id));
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            // Bind data
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':middle_name', $this->middle_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role_id', $this->role_id);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':user_id', $this->user_id);
            
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            $this->error_info = $stmt->errorInfo();

            return false;
        }

        // Delete User
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            // Bind data
            $stmt->bindParam(':user_id', $this->user_id);

            // Execute query
            if($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return true;
                }
                $this->error_info = "User doesn't exists.";
                return false;
            }

            $this->error_info = $stmt->errorInfo();

            return false;
        }

    }
    