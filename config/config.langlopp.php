<?php
  if ($environment == "dev") { 
    define("URL_ROOT", "http://supranking.dev:8888/langlopp");
  } else {
	  define("URL_ROOT", "http://supraceserien.se/langlopp");
  }

  define("DATABASE_TABLE_PREFIX",	"langlopp");

	define("TITLE", "Långloppsserien 2016 SUP");
	define("TITLE_SHORT", "Långlopp 2016");
	define("LOGO_IMAGE", "/images/langlopp_2016.png");
  define("BACKGROUND_IMAGE", "/images/bg_langlopp_2016.png");
	
	define("COMPETITIONS_ADDED_TO_SUM", 4);
	define("HAS_CLASSES", false);
	
  define("DISCIPLINES", serialize(array('distance')));
?>