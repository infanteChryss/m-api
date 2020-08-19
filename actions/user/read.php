<?php 
    
    
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once(__DIR__ . '/../../Database.php');
    include_once(__DIR__ . '/../../classes/User.php');

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    if ($db) {

        // Instantiate users object
        $user = new User($db);

        // Get ID
        $query_type = empty($request_id) ? "all" : $user->user_id = $request_id;

        if ($query_type == "all") {
            // User query
            $result = $user->read($query_type);    
            if ($result) {
                // Check if there's any users
                if($result->rowCount() > 0) {
                    // User array
                    $users_arr = array();
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $user_item = array(
                            'user_id' => $user_id,
                            'first_name' => $first_name,
                            'middle_name' => $middle_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'username' => $username,
                            'password' => $password,
                            'role' => $role,
                            'role_id' => $role_id,
                            'status' => $status
                        );
                        // Push to "data"
                        array_push($users_arr, $user_item);
                    }
                    // Turn to JSON & output
                    new Response(true, $users_arr);
                } else {
                    // No Users
                    new Response(false, "No Users Found");
                }
            } else {
                new Response(false, "Unable to execute database query.");
            }
        } else {
            $result = $user->read($query_type);    
            if (!empty($result)) {            
                // Set properties
                $user_arr = array(
                  'user_id' => $result['user_id'],
                  'first_name' => $result['first_name'],
                  'middle_name' => $result['middle_name'],
                  'last_name' => $result['last_name'],
                  'email' => $result['email'],
                  'username' => $result['username'],
                  'password' => $result['password'],
                  'role' => $result['role'],
                  'role_id' => $result['role_id'],
                  'status' => $result['status']
                );
                    new Response(true, $user_arr);
            } else {
                new Response(false, "No User Found");
            }
        }
    
    } else {
        new Response(false, "Database Connection Error.");
    }
