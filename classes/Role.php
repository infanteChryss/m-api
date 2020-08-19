<?php

    class Role {

        // DB stuff
        private $conn;
        private $table = 'roles';


        // Role Properties
        public $role_id;
        public $code;
        public $name;
        public $description;
        
        public $error_info;

        // constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        // Get Roles
        public function read($query_type) {

            if ($query_type == "all") {
                // Create query
                $query = 'SELECT * FROM ' .$this->table. ' ORDER BY name ASC';
                
                // Prepare statement
                $stmt = $this->conn->prepare($query);
                // Execute Query
                if ($stmt->execute()) {
                    return $stmt;
                } 
                return false;
            } else {
                // Create query
                $query = 'SELECT * FROM ' .$this->table. '
                        WHERE role_id = ?
                        LIMIT 0,1';
                
                // Prepare statement
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(1, $this->role_id);

                if($stmt->execute()) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
                return null;
            }
        }

        // Create Role
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table .
                    ' SET
                        role_id = :role_id,
                        code = :code,
                        name = :name,
                        description = :description';
  
            // Prepare statement
            $stmt = $this->conn->prepare($query);
  
            // Clean data
            $this->role_id = htmlspecialchars(strip_tags($this->role_id));
            $this->code = htmlspecialchars(strip_tags($this->code));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
  
            // Bind data
            $stmt->bindParam(':role_id', $this->role_id);
            $stmt->bindParam(':code', $this->code);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
  
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            $this->error_info = $stmt->errorInfo();

            return false;
        }

        // Update Role
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . 
                        ' SET
                            code = :code,
                            name = :name,
                            description = :description
                        WHERE role_id = :role_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->code = htmlspecialchars(strip_tags($this->code));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->role_id = htmlspecialchars(strip_tags($this->role_id));

            // Bind data
            $stmt->bindParam(':code', $this->code);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':role_id', $this->role_id);
            
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            $this->error_info = $stmt->errorInfo();

            return false;
        }

        // Delete Role
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE role_id = :role_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->role_id = htmlspecialchars(strip_tags($this->role_id));

            // Bind data
            $stmt->bindParam(':role_id', $this->role_id);

            // Execute query
            if($stmt->execute()) {
                if ($stmt->rowCount() >= 1) {
                    return true;
                }
                $this->error_info = "Role doesn't exists.";
                return false;
            }

            $this->error_info = $stmt->errorInfo();

            return false;
        }

    }
    