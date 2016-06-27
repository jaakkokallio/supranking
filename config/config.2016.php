<?php
  if ($environment == "dev") { 
    error_reporting(E_ALL & ~E_DEPRECATED);

    define("DATABASE_HOST",	"localhost");
    define("DATABASE_USERNAME",	"root");
    define("DATABASE_PASSWORD",	"batman");
    define("DATABASE_DATABASE",	"supranking");

    define("URL_ROOT", "http://supranking.dev:8888");
  } else {
  	define("DATABASE_HOST",	"127.0.0.1");
  	define("DATABASE_USERNAME",	"root");
  	define("DATABASE_PASSWORD",	"piZZakoLLektivet");
  	define("DATABASE_DATABASE",	"supranking");
  
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