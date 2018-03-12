<?PHP
 /*$subject = 'djfklsdjfkl';
 $playerid =[];
 $playerid[] = '5d8689ba-9df8-41c4-afd4-6ac28a8285a3';*/
 

 
//print_r($player_id); 
    function sendMessage($subject,$playerid){
               echo json_encode($playerid);
		$content = array(
			"en" => $subject
			);
		
		$fields = array(
			'app_id' => "66f4ac3c-5360-4957-b5ef-e0ec3cc8f156",
			'include_player_ids' => $playerid,
			'data' => array("foo" => "bar"),
			'contents' => $content
		);
		
	$fields = json_encode($fields);
    	//print("\nJSON sent:\n");
    	//print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	/*$response = sendMessage($subject,$playerid);
	$return["allresponses"] = $response;
	$return = json_encode( $return);
	
	print("\n\nJSON received:\n");
	print($return);
	print("\n");*/
?>