<?php
	include_once(__DIR__ . "/database.php");

	$db = new Database();
	$posted_by = "";
	$post_caption = "";
	$photo = "";
	$data = array("errors" => array(), "data" => array());

	if (!isset($_POST["posted_by"]) || $_POST["posted_by"] == ""){
		$error = array("error" => "The user posting a post isn't defined.");
		array_push($data["errors"], $error);
		echo (json_encode($data));
	}else {
		$posted_by = $_POST["posted_by"];
	}

	if (!isset($_POST["caption"]) || $_POST["caption"] == ""){ 
		$error = array("error" => "Write something for the post.");
		array_push($data["errors"], $error);
	}else {
		$post_caption = $_POST["caption"];
	}

	if (!isset($_FILES["file"]["name"])){
		$error = array("error" => "Photo is not set.");
		array_push($data["errors"], $error);
		echo json_encode($data);
	}else {
		$filename = $_FILES["file"]["name"];
		
		$location = "uploads/" . md5($filename) . rand();
		$imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
		$imageFileType = strtolower($imageFileType);
		
		$valid_extentions = array("jpg", "jpeg", "png");
		
		if (in_array($imageFileType, $valid_extentions)){
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $location . "." . $imageFileType)){
				$photo = $location . "." . $imageFileType;
			}else {
				print_r(ini_get("upload_max_filesize"));
			}
		}
	}

	echo $db->insertMemories($post_caption, $photo, $posted_by);

	//echo json_encode($data);

?>