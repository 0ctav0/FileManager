<?php	
	if ( isset($_POST['c_hide_footer']) ) {
		setcookie("c_hide_footer", $_POST['c_hide_footer']);
		//echo "<script>alert(\"isset post c_hide_footer is $_POST[c_hide_footer]\");</script>";
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8"/>
	
	<title>Файловый обменик</title>
	<link rel="stylesheet" href="styles.css">
	<script src="js/jquery-3.2.0.min.js"></script>
	<script src="js/app.js"></script>
</head>
<body>

<?php 
	$files = array();
	$folders = array();
	$count = 0;

	
	if ( $_GET["dir"] === null ) {
		$dirName = "files";	
	} else {
		$dirName = $_GET["dir"];
		$prevDirName = preg_replace('#/[^/]+$#', '', $dirName, -1, $count);
		
	
	}
	echo "<h1>Файловый обменник ☺ Путь: $dirName</h1>";
	if ( $count !== 0 ) {
		echo "<div class=\"cloud_e\"><a href=\"index.php?dir=$prevDirName\"><img src=\"img/folder_back.png\"><p style=\"font-size:25px\">..</p></a></div>";
	}
	$fName = $_FILES['toProcess']['name'];
	$fTmpName = $_FILES['toProcess']['tmp_name'];
	if ( is_uploaded_file($fTmpName) ) {
		//echo "<script>alert(\"hello\");</script>";
		move_uploaded_file($fTmpName, "{$dirName}/{$fName}");
	}
?>
<div class="content">
<?php 
	$dir = opendir($dirName); // dir is resource
	while ( false !== ($entry = readdir($dir)) ) {
		if ( $entry != "." && $entry != "..") {
			//$infFileTmp = array(iconv("", "UTF-8", $entry), 
								//preg_match("/\./", $entry) ? "1" : "0" ); // 1 is file, 0 is folder
			//$files[] = $infFileTmp;
			if ( preg_match("/\./", $entry) ) {
				$files[] = iconv("", "UTF-8", $entry);
			} else {
				$folders[] = iconv("", "UTF-8", $entry);
			}
		}
	}
	//!// sort files as "folder-a-z-file-a-z" using indexes what was defined above
	
	
	// Output folders
	foreach ($folders as $val) {
		$path = ("index.php?dir=$dirName/$val");
		echo "<div class=\"cloud_e\"><a href=\"$path\"><img src=\"img/folder.png\"><p>$val</p></a></div>";
	}	
	// Output files
	//$start = microtime(true);
	foreach ($files as $val) {
		$path = ("$dirName/$val");
		if ( preg_match("/(\.mp3$)|(\.m3u8$)/", $val) ) {
			echo "<div class=\"cloud_e\"><a download href=\"$path\"><img src=\"img/SomeFileO.png\"><p>$val</p></a></div>";
		} else if ( preg_match("/(\.rar$)|(\.7z$)/", $val) ) {
			echo "<div class=\"cloud_e\"><a download href=\"$path\"><img src=\"img/Rar.png\"><p>$val</p></a></div>";
		} else {
			echo "<div class=\"cloud_e\"><a download href=\"$path\"><img src=\"img/SomeFileB.png\"><p>$val</p></a></div>";
		}	
	}
	//echo microtime(true) - $start;
?>

<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<p>
	<input type="hidden" name="MAX_FILE_SIZE" value="10240000">
	Добавить файл: <input name="toProcess" type="file" />
	<input type="submit" value="Upload" />
</p>
</form>
</div>

<footer>
<a href="#"><div class="fader"></div></a>
<div class="snowflakes"></div>
<div class="characters">
	<img src="img/olaf.png">
	<img src="img/sven.png">
	<img src="img/elsa.png">
	<img src="img/anna.png">
	<img src="img/kristoff.png">
</div>
</footer>
<?php

	if ( isset($_COOKIE['c_hide_footer']) ) {
		//echo "<script>alert(\"isset cookie! c_hide_footer is $_COOKIE[c_hide_footer]\");</script>";
		if ( $_COOKIE['c_hide_footer'] == 1 ) {
			echo "<script>hide();</script>";
		} else {
			echo "<script>show();</script>";
		}
	}
?>
</body>
</html>