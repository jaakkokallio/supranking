<?php  
  global $environment, $dir, $page, $id;
 
  $environment = ($_SERVER["SERVER_NAME"] == "supranking.dev") ? "dev" : "prod";
  $params = array_values(preg_grep("/^[a-z0-9-\/]+$/", explode("/", $_SERVER['REQUEST_URI'])));
  $dir = "";
  if (sizeof($params) > 0 && in_array($params[0], array("2014","2015","langlopp"))) {
    $dir = "/".$params[0];
    unset($params[0]);
    $params = array_values($params);
  }
  $page = sizeof($params) > 0 ? $params[0] : "front";
  $id = sizeof($params) > 1 ? $params[1] : NULL;
  
  include("functions.php");
	include("config".$dir."/config.".$environment.".php");
	include("database.php");
  include($page.".php");
?>