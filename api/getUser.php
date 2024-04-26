<?php
    
    include 'validate.php';
    global $token_valid;
    
	if($token_valid ==1)  // Handle incoming requests
	{
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        switch ($requestMethod) {
            case 'GET':
                $name = $_GET['user'] ?? '';
                $response = getUser($name);
                break;
            default:
                $response = array('error' => 'Unsupported request method');
                break;
        }
	}
	
	// Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
	
	
	
    function getUser($name) {
        if(isset($name))
        {
            // do all the operation here for this endpoint here ..................................................................................................
            $data_val["user"] = $name;
            $data_val["name"] = "Md Nasir";
            $data_val["message"] = "Hi Nasir";
            $data_val["country"] = "Bangladesh";
        }
        else
        {
            $data_val["error"] = "no data found";
        }
        $ee["status"] = "OK";
        $ee["responseTime"] = date("Y-m-d H:i:s");
        $ee["response"] = $data_val;
        
        return $ee;
    }
    
    