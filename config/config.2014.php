<?php
  if ($environment == "dev") { 
    error_reporting(E_ALL & ~E_DEPRECATED);

    define("DATABASE_HOST",	"localhost");
    define("DATABASE_USERNAME",	"root");
    define("DATABASE_PASSWORD",	"batman");
    define("DATABASE_DATABASE",	"supranking");

    define("URL_ROOT", "http://supranking.dev:8888/2014");
  } else {
    define("DATABASE_HOST",	"127.0.0.1");
    define("DATABASE_USERNAME",	"root");
    define("DATABASE_PASSWORD",	"piZZakoLLektivet");
    define("DATABASE_DATABASE",	"supranking");

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