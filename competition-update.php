<?php 
	include("functions.php");
	if (is_logged_in()) {
		if (update_competition($_POST["id"], $_POST["name"], $_POST["urlname"], $_POST["start_date"], $_POST["end_date"], $_POST["distance"], $_POST["status"], $_POST["description"])) {
			header("Location: /admin?success=update-competition");
		} else {
			header("Location: /admin?error=update-competition");
		}
	} else {
		header("Location: /admin?error=login");
	}
?>