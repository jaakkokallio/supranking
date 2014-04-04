<?php 
	include("functions.php");
	if (is_logged_in()) {
		if (create_competition($_POST["name"], $_POST["start_date"], $_POST["end_date"], $_POST["status"], $_POST["description"])) {
			header("Location: admin.php?success=create-competition");
		} else {
			header("Location: admin.php?error=create-competition");
		}
	} else {
		header("Location: admin.php?error=login");
	}
?>