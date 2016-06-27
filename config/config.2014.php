<?php
  if ($environment == "dev") { 
    define("URL_ROOT", "http://supranking.dev:8888/2014");
  } else {
    define("URL_ROOT", "http://supraceserien.se/2014");
  }
  
  define("DATABASE_TABLE_PREFIX",	"2014");
	
	define("TITLE", "Svenska SUP Race Serien 2014");
	define("TITLE_SHORT", "2014");
	define("LOGO_IMAGE", "/images/ssrs-logo.png");
  define("BACKGROUND_IMAGE", "/images/bg.jpg");
	
	define("COMPETITIONS_ADDED_TO_SUM", 6);
	define("HAS_CLASSES", true);
	
  define("DISCIPLINES", serialize(array('distance', 'sprint')));
?>