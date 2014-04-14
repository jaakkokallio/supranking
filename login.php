<?php
	include("functions.php");
	if (isset($_POST["email"]) && isset($_POST["password"]) && login($_POST["email"], $_POST["password"])) {
		header("Location: /admin");
	} else {
		$email = (isset($_POST["email"])) ? $_POST["email"] : "";
		header("Location: /admin?error=login&email=".$email);
	}
?>