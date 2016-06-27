<?php  
  global $environment, $config, $page, $id;
 
  $environment = ($_SERVER["SERVER_NAME"] == "supranking.dev") ? "dev" : "prod";
  $params = array_values(preg_grep("/^[a-z0-9-\/]+$/", explode("/", preg_replace("/\?.*/", "", $_SERVER['REQUEST_URI']))));
  $config = "2016";
  if (sizeof($params) > 0 && in_array($params[0], array("2014","2015","langlopp"))) {
    $config = $params[0];
    unset($params[0]);
    $params = array_values($params);
  }
  $page = sizeof($params) > 0 ? $params[0] : "front";
  $id = sizeof($params) > 1 ? $params[1] : NULL;
    
  include("config/config.default.php");
	include("config/config.".$config.".php");
  include("functions.php");
	include("database.php");
  include($page.".php");
?>