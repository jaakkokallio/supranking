<?php
  if ($environment == "dev") { 
    define("URL_ROOT", "http://supranking.dev:8888");
  } else {
  	define("URL_ROOT", "http://supraceserien.se");
  }
  
	define("DATABASE_TABLE_PREFIX",	"2016");
  
	define("TITLE", "Svenska SUP Race Serien 2016");	
  define("TITLE_SHORT", "2016");
	define("LOGO_IMAGE", "/images/ssrs-logo.png");
	define("BACKGROUND_IMAGE", "/images/bg_ssrs_2016.png");
	
	define("COMPETITIONS_ADDED_TO_SUM", 4);
	define("HAS_CLASSES", false);
	
  define("DISCIPLINES", serialize(array('distance', 'sprint')));
?>