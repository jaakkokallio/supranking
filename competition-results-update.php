<?php 
	include("functions.php");
	if (is_logged_in()) {
		
	} else {
		header('HTTP/1.0 404 Not Found');
	}
?>