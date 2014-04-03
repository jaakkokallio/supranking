<?php
	include("functions.php");
	if (isset($_POST["username"]) && isset($_POST["password"]) && login($_POST["username"], $_POST["password"])) {
		header("Location: admin.php");
	} else {
		header("Location: admin.php?error=login");
	}
?>