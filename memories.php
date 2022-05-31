<?php
	include_once(__DIR__ . "/database.php");
	
	$data = array();
	$db = new Database();
	$responses = $db->fetchMemories();
		
	if ($responses->num_rows == 0){
		echo json_encode(array("error" => "No posts available."));
		die();
	}
		
	$response = $responses->fetch_assoc();

	do {
		$row = array(
			"id" => $response["id"],
			"caption" => $response["caption"],
			"photo" => $response["photo"],
			"posted_by" => $response["posted_by"],
		);
			
		array_push($data, $row);
	} while ($response = $responses->fetch_assoc());
		
	echo json_encode($data);
?>