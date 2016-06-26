<?php 
	if (is_logged_in()) {
		echo json_encode(array("discipline" => $_POST["discipline"], "competitors" => create_competitors($_POST["competitor"])));
	} else {
		header('HTTP/1.0 404 Not Found');
	}
?>