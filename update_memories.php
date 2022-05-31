<?php
	include_once (__DIR__ ."/database.php");

	if (!isset($_POST["posted_by"]) && !isset($_POST["post_id"]) && !isset($_POST["caption"]))
	{
		echo "Necessary paremeters aren't set.";
		die();
	}

	$db = new Database();

	$id = filter_var($_POST["post_id"], FILTER_SANITIZE_STRING);
	$posted_by = filter_var($_POST["posted_by"], FILTER_SANITIZE_STRING);
	$caption = filter_var($_POST["caption"], FILTER_SANITIZE_STRING);

	$result = $db->updateMemories($id, $posted_by, $caption);

	echo $result;
?>