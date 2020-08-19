<?php	

    require_once("Response.php");
    
    $url = isset($_GET['url']) ? $_GET['url'] : '404';

    $request = explode('/', $url);

    $r_length = count($request);

    if ($r_length > 3) {
        new Response(false, "Invalid Url.");
    } else {
        $class = empty($request[0]) ? null : $request[0];
        $action = empty($request[1]) ? null : $request[1];
        $request_id = empty($request[2]) ? null : $request[2];
        $path = rtrim("actions/$class/$action", "/\\");
        if (file_exists("$path.php")) {
            require_once("$path.php");
        } else {
            new Response(false, "Invalid Url.");
        }
    }
    
