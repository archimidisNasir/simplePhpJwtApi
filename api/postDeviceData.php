<?php
    
    include 'validate.php';
    global $token_valid;
    
	if($token_valid ==1)  // Handle incoming requests
	{
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        switch ($requestMethod) {
            case 'POST':
                $postData = file_get_contents('php://input');
                $jsonData = json_decode($postData, true);
                
                // Check if JSON decoding was successful
                if ($jsonData === null) {
                    $response = array('error' => 'Invalid JSON data');
                } else {
                    // Call the appropriate endpoint function with the JSON data
                    $response = postUserData($jsonData);
                }
                break;
            default:
                $response = array('error' => 'Unsupported request method');
                break;
        }
	}
	
	// Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
	
	
    function postUserData($data) {
        if(isset($data["device"]))
        {
            // do all the operation here for this endpoint here ..................................................................................................
            $data_val["device"] = $data["device"];
            $data_val["model"] = "A9-GT06";
            $data_val["imei"] = "1334445556";
            $data_val["iccid"] = "88123456789123";
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
    
    