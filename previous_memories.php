<?php
	include_once(__DIR__ . "/database.php");

	if (isset($_GET["username"]))
	{
		$username = $_GET["username"];
	}else {
		echo "Necessary parameter isn't set.";
		die();
	}
	$data = array();
	$db = new Database();
	$responses = $db->fetchPreviousMemories($username);
		
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