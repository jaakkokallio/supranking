<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
        <title><?php echo TITLE; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo TITLE; ?>" />
        <meta name="keywords" content="SUP, Svenska SUP Race Serien, Stand up paddling, Stand up paddle tävlingar" />
       
        <meta property="og:title" content="<?php echo TITLE; ?>" />
        <meta property="og:type" content="sport"/>
        <meta property="og:url" content="<?php echo URL_ROOT; ?>"/>
        <meta property="og:image" content="<?php echo URL_ROOT; ?>/images/swesuprankings-fb.png"/>
        <meta property="og:site_name" content="supraceserien.se"/>
        <meta property="fb:admins" content="jacobi85"/>
        <meta property="og:description"
              content="Svenska SUP Race Serien - Sveriges bästa Stå-upp paddlare."/>

        <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="/css/main.css" type="text/css" />
        <link rel="stylesheet" href="/css/datepicker.css" type="text/css" />
        <link rel="stylesheet" href="/css/jquery.handsontable.full.css" type="text/css" />

		    <script type="text/javascript">
          window.translations = <?php echo json_encode(unserialize(TRANSLATIONS)); ?>;
			    window.urlRoot = "<?php echo URL_ROOT; ?>";
		    </script>

        <script src="/js/jquery.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/bootstrap.js"></script>
		<script src="/js/bootstrap-datepicker.js"></script>
        <script src="/js/jquery.dataTables.js"></script>
        <script src="/js/DT_bootstrap.js"></script>
        <script src="/js/jquery.handsontable.full.js"></script>
	
    </head>
    <body id="index" class="home" style="background:url(<?php echo BACKGROUND_IMAGE; ?>)">
      <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="span12">
            <a class="brand" href="<?php echo URL_ROOT; ?>"><?php echo TITLE; ?></a>
            <ul class="nav">
              <li class="dropdown <?php if (page() != "admin" && page() != "how") { ?>active<?php } ?>">
                  <a href="<?php echo URL_ROOT; ?>" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo TITLE_SHORT; ?>
                    <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                    <?php foreach (dropdown_menu_items() as $href => $text) { ?>
                      <?php if ($text == "divider") { ?>
                        <li class="divider"></li>
                      <?php } else { ?>
                        <li><a tabindex="-1" href="<?php echo $href; ?>"><?php echo $text; ?></a></li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
              </li>

        			<?php if (is_logged_in()) { ?>
        			  <li<?php if (page() == "admin") { ?> class="active"<?php } ?>><a href="<?php echo URL_ROOT; ?>/admin"><?php echo t("administer"); ?></a></li>
        				<li><a href="<?php echo URL_ROOT; ?>/logout"><?php echo t("logout"); ?></a></li>
        			<?php } else { ?>
        			  <li<?php if (page() == "how") { ?> class="active"<?php } ?>><a href="<?php echo URL_ROOT; ?>/how"><?php echo t("about"); ?></a></li>	
                <li<?php if (page() == "admin") { ?> class="active"<?php } ?>><a href="<?php echo URL_ROOT; ?>/admin"><?php echo t("login"); ?></a></li>				       
        			<?php } ?>	
            </ul>
          </div>
        </div>
      </div>
        <div class="container">
          
            <div class="row-fluid">
                <div class="header-wrapper span12">
                <header id="top-header" class="span12">
                    <a href="<?php echo URL_ROOT; ?>"><img src="<?php echo LOGO_IMAGE; ?>" /></a>
                </header>
                
                
