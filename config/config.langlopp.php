<?php
  if ($environment == "dev") { 
    error_reporting(E_ALL & ~E_DEPRECATED);

  	define("DATABASE_HOST",	"localhost");
  	define("DATABASE_USERNAME",	"root");
  	define("DATABASE_PASSWORD",	"batman");
  	define("DATABASE_DATABASE",	"supranking");

    define("URL_ROOT", "http://supranking.dev:8888/langlopp");
  } else {
	  define("DATABASE_HOST",	"127.0.0.1");
	  define("DATABASE_USERNAME",	"root");
	  define("DATABASE_PASSWORD",	"piZZakoLLektivet");
	  define("DATABASE_DATABASE",	"supranking");

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