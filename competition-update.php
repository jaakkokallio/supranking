<?php 
	if (is_logged_in()) {
		if (update_competition($_POST["id"], $_POST["name"], $_POST["urlname"], $_POST["start_date"], $_POST["end_date"], $_POST["sprint_length"], $_POST["distance_length"], $_POST["sprint_length_female"], $_POST["distance_length_female"], $_POST["status"], $_POST["description"])) {
			header("Location: ".URL_ROOT."/admin?success=update-competition");
		} else {
			header("Location: ".URL_ROOT."/admin?error=update-competition");
		}
	} else {
		header("Location: ".URL_ROOT."/admin?error=login");
	}
?>