<?php 

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data)) {

        include_once(__DIR__ . '/../../Database.php');
        include_once(__DIR__ . '/../../classes/User.php');
    
        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();
    
        if ($db) {
    
            // Instantiate user object
            $user = new User($db);
    
            // Get raw user data
    
            $user->first_name = $data->first_name;
            $user->middle_name = $data->middle_name;
            $user->last_name = $data->last_name;
            $user->email = $data->email;
            $user->username = $data->username;
            $user->password = $data->password;
            $user->role_id = $data->role_id;
            $user->status = $data->status;
    
            // Create user
            if($user->create()) {
                new Response(true, 'User successfully created');
            } else {
                new Response(false, $user->error_info);
            }
        } else {
            new Response(false, "Database Connection Error.");
        }
    } else {
        echo json_encode( array("status" => false, "message" => "No data found.") );
    }
    