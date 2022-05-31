<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta property="og:title"  content="Dave & Meka" />
		<meta property="og:url" content="http://meka.gq"/>
		<meta property="og:description" content="Everyday every night we make memories!"/>
		<meta property="og:image" content="icon.png"/>
		<meta property="og:type" content="article"/>
		<link rel="shortcut icon" href="img/favicon.png"/>
		<link href="css/desktop.css" rel="stylesheet"/>
		<link href="css/mobile.css" rel="stylesheet"/>
		<title>Dave & Meka</title>
	</head>
	<body>
		<?php
			session_start();
			
			if (!isset($_SESSION["username"]))
			{
				$_SESSION["username"] = NULL;
				header("Location: login.php");
				die();
			}
		?>
	</body>
</html>