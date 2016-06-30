<?php
  if ($environment == "dev") { 
    define("URL_ROOT", "http://supranking.fi.dev:8888");
  } else {
  	define("URL_ROOT", "http://ranking.finssf.fi");
  }
  
	define("DATABASE_TABLE_PREFIX",	"fi_2016");
  
	define("TITLE", "Finnish SUP Ranking 2016");	
  define("TITLE_SHORT", "2016");
	define("LOGO_IMAGE", "/images/fi_sup_ranking.png");
	define("BACKGROUND_IMAGE", "/images/bg_ssrs_2016.png");
	
	define("COMPETITIONS_ADDED_TO_SUM", 4);
	define("HAS_CLASSES", false);
	
  define("DISCIPLINES", serialize(array('distance', 'sprint')));
?>