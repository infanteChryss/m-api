<?php 
    
    
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once(__DIR__ . '/../../Database.php');
    include_once(__DIR__ . '/../../classes/Role.php');

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    if ($db) {

        // Instantiate roles object
        $role = new Role($db);

        // Get ID
        $query_type = empty($request_id) ? "all" : $role->role_id = $request_id;

        if ($query_type == "all") {
            // Role query
            $result = $role->read($query_type);    
            if ($result) {
                // Check if there's any roles
                if($result->rowCount() > 0) {
                    // Role array
                    $roles_arr = array();
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $role_item = array(
                            'role_id' => $role_id,
                            'code' => $code,
                            'name' => $name,
                            'description' => $description
                        );
                        // Push to "data"
                        array_push($roles_arr, $role_item);
                    }
                    // Turn to JSON & output
                    new Response(true, $roles_arr);
                } else {
                    // No Roles
                    new Response(false, "No Roles Found");
                }
            } else {
                new Response(false, "Unable to execute database query.");
            }
        } else {
            $result = $role->read($query_type);    
            if (!empty($result)) {            
                // Set properties
                $role_arr = array(
                  'role_id' => $result['role_id'],
                  'code' => $result['code'],
                  'name' => $result['name'],
                  'description' => $result['description']
                );
                    new Response(true, $role_arr);
            } else {
                new Response(false, "No Role Found");
            }
        }
    
    } else {
        new Response(false, "Database Connection Error.");
    }
