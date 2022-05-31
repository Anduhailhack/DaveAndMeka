<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta property="og:title"  content="Dave & Meka" />
		<meta property="og:url" content="http://meka.cf"/>
		<meta property="og:description" content="Everyday every night we make memories!"/>
		<meta property="og:image" content="icon.png"/>
		<meta property="og:type" content="article"/>
		<link rel="shortcut icon" href="img/favicon.png"/>
		<link href="./css/desktop.css" rel="stylesheet"/>
		<link href="./css/mobile.css" rel="stylesheet"/>
		<title>Dave & Meka</title>
	</head>
	<body>
		<?php
			session_start();
			
			if (!isset($_SESSION["username"]))
			{
				// $_SESSION["username"] = NULL;
				// header("Location: login.php");
				// die();
				$_SESSION["username"] = "@Meka"; 
			}
            //header("Location: 404_page.html");
            //die();
		?>
		<div id="Tabs">
		<header>
			<nav> 
				<div class="brand-wrapper">
					<a href="#"><img id ="brand-img" src="img/brand.png" alt="Logo"/></a>
				</div>
			   <div class="tabs-wrapper">
					<ul>
						<li><a id="home-btn" href="#home" class="material-icons">home</a></li>
						<li><a id="menu-btn" href="#menu" class="material-icons">menu</a></li>
					</ul>
				</div>
			</nav>
		</header>
		<main>
			<div id="home">
				<div class="main-wrapper">
					
				</div>
				<div id="load-more" class="load-more">
<!--
					<a href="#loadmore" class="load-more-btn material-icons">
						keyboard_arrow_down
					</a>
-->
					Loading ...
				</div>
			</div>
			<div id="menu">
				<div class="menu-wrapper" id="menu-wrapper">
					<div class="tabs-wrapper">
						<ul>
							<li><a id="create-post-tab-btn" class="material-icons" href="#tabs-1">rate_review</a></li>
							<li><a id="previous-post-tab-btn" class="material-icons" href="#tabs-2">speaker_notes</a></li>
						</ul>
					</div>
					<div class="main-menu-container">
						<div id="tabs-1">
							<h3>Create post</h3>
							<div class="create-post-container">
								<div class="img-create-post">
									<button id="add-img-btn"><li class="material-icons">camera</li></button>
									<img id="add-img" src=""/>
								</div>
								<form class="data-form" id="data-form" action="post_memories.php" method="post" enctype="multipart/form-data">
									<?php
										echo "<input id='username' type='hidden' value='" . $_SESSION["username"] . "'/>";
									?> 
									<textarea id="create-post-caption" placeholder="What's on your mind?"></textarea>
									<input type="file" id="post-file"  accept="image/*"/>
									<input type="button" id="post-btn" value="Post"/>
								</form>
							</div>
						</div>
						<div id="tabs-2">
							<h3>Previous posts</h3>
							<div class="previous-post-container">
							</div>
							<div id="load-more" class="load-more">
								Loading ...
							</div>
						</div>
					</div>
				 </div>
			</div>
		</main>
		</div> 
		<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
		<script src="jQueryAssets/jquery.ui-1.10.4.tabs.min.js"></script>
		<script src="jQueryAssets/jquery.ui-1.10.4.dialog.min.js"></script>
		<script type="text/javascript" src="js/app.js"></script>
		<script type="text/javascript" src="js/app-pure.js"></script>
	</body>
</html>