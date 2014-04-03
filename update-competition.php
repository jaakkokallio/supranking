<?php 
	include("functions.php");
	if (is_logged_in()) {
		if (update_competition($_POST["id"], $_POST["name"], $_POST["start_date"], $_POST["end_date"], $_POST["description"])) {
			header("Location: admin.php?success=update-competition");
		} else {
			header("Location: admin.php?error=update-competition");
		}
	} else {
		header("Location: admin.php?error=login");
	}
?>