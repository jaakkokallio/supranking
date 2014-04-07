<?php 
	include("functions.php");
	if (is_logged_in()) {
		if (update_competitor($_POST["id"], $_POST["first_name"], $_POST["last_name"], $_POST["gender"], $_POST["country"])) {
			header("Location: /admin?success=update-competitor");
		} else {
			header("Location: /admin?error=update-competitor");
		}
	} else {
		header("Location: /admin?error=login");
	}
?>