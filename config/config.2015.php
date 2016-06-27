<?php
  if ($environment == "dev") { 
    define("URL_ROOT", "http://supranking.dev:8888/2015");
  } else {
    define("URL_ROOT", "http://supraceserien.se/2015");
  }
  
  define("DATABASE_TABLE_PREFIX",	"2015");

	define("TITLE", "Svenska SUP Race Serien 2015");
	define("TITLE_SHORT", "2015");
	define("LOGO_IMAGE", "/images/ssrs-logo.png");
  define("BACKGROUND_IMAGE", "/images/bg.jpg");
	
	define("COMPETITIONS_ADDED_TO_SUM", 4);
	define("HAS_CLASSES", false);
	
  define("DISCIPLINES", serialize(array('distance', 'sprint')));
?>