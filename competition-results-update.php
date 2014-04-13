<?php 
	include("functions.php");
	if (is_logged_in()) {
		echo json_encode(update_results($_POST["competition_id"], $_POST["results"]));
	} else {
		header('HTTP/1.0 404 Not Found');
	}
?>