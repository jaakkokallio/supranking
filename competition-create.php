<?php 
	include("functions.php");
	if (is_logged_in()) {
		if (create_competition($_POST["name"], $_POST["urlname"], $_POST["start_date"], $_POST["end_date"],  $_POST["sprint_length"], $_POST["distance_length"], $_POST["status"], $_POST["description"])) {
			header("Location: ".URL_ROOT."/admin?success=create-competition");
		} else {
			header("Location: ".URL_ROOT."/admin?error=create-competition");
		}
	} else {
		header("Location: ".URL_ROOT."/admin?error=login");
	}
?>