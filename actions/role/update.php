<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data)) {

        include_once(__DIR__ . '/../../Database.php');
        include_once(__DIR__ . '/../../classes/Role.php');
    
        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();
    
        if ($db) {
                        
            // Instantiate role object
            $role = new Role($db);
            
            if (!empty($request_id)) {
                // Set ID to update
                $role->role_id = $request_id;
                // Get raw role data
                $role->code = $data->code;
                $role->name = $data->name;
                $role->description = $data->description;
        
                // Create role
                if($role->update()) {
                    new Response(true, 'Role successfully updated');
                } else {
                    new Response(false, $role->error_info);
                }
            } else {
                new Response(false, 'Please specify role to update.');
            }

        } else {
            new Response(false, "Database Connection Error.");
        }
    } else {
        echo json_encode( array("status" => false, "message" => "No data found.") );
    }