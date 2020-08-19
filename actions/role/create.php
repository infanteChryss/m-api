<?php 

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

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
    
            // Get raw role data
    
            $role->role_id = $data->role_id;
            $role->code = $data->code;
            $role->name = $data->name;
            $role->description = $data->description;
    
            // Create role
            if($role->create()) {
                new Response(true, 'Role successfully created');
            } else {
                new Response(false, $role->error_info);
            }
        } else {
            new Response(false, "Database Connection Error.");
        }
    } else {
        echo json_encode( array("status" => false, "message" => "No data found.") );
    }
    