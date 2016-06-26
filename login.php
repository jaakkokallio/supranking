<?php
	if (isset($_POST["email"]) && isset($_POST["password"]) && login($_POST["email"], $_POST["password"])) {
		header("Location: ".URL_ROOT."/admin");
	} else {
		$email = (isset($_POST["email"])) ? $_POST["email"] : "";
		header("Location: ".URL_ROOT."/admin?error=login&email=".$email);
	}
?>