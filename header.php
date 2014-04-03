<?php include("functions.php"); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
        <title>Svenska SUP Race Serien</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Svenska SUP Race Serien" />
        <meta name="keywords" content="SUP, Svenska SUP Race Serien, Stand up paddling, Stand up paddle tävlingar" />
       
        <meta property="og:title" content="Svenska SUP Race Serien" />
        <meta property="og:type" content="sport"/>
        <meta property="og:url" content="http://supraceserien.se"/>
        <meta property="og:image" content="http://supraceserien.se/images/swesuprankings-fb.png"/>
        <meta property="og:site_name" content="supraceserien.se"/>
        <meta property="fb:admins" content="jacobi85"/>
        <meta property="og:description"
              content="Svenska SUP Race Serien - Sveriges bästa Stå-upp paddlare."/>

        <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="css/main.css" type="text/css" />
        <link rel="stylesheet" href="css/datepicker.css" type="text/css" />

        <!--[if IE]>
                <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!--[if lte IE 7]>
                <script src="js/IE8.js" type="text/javascript"></script><![endif]-->
        <!--[if lt IE 7]>

	<link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/><![endif]-->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/main.js"></script>
        <script src="js/bootstrap.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/DT_bootstrap.js"></script>
    </head>
    <body id="index" class="home">
        <div class="container">
            <div class="row-fluid">
                <div class="header-wrapper span12">
                <header id="top-header" class="span6">
                    <h1 id="topLogo"><a href="index.php" title="Swedish SUP Rankings">Swedish SUP Rankings</a></h1>
                    <h1 id="topLogo-mini"><a href="index.php" title="Swedish SUP Rankings">Swedish SUP Rankings</a></h1>
                </header>
				<div class="navbar navbar-static-top span5 pull-right">
				    <ul class="nav pull-right">
				        <li<?php if (page() == "index") { ?> class="active"<?php } ?>><a href="index.php">Ranking</a></li>				
				        <?php if (is_logged_in()) { ?>
							<li<?php if (page() == "admin") { ?> class="active"<?php } ?>><a href="admin.php">Administrera</a></li>
							<li><a href="logout.php">Logga ut</a></li>
						<?php } else { ?>
							<li<?php if (page() == "how") { ?> class="active"<?php } ?>><a href="how.php">Så fungerar det</a></li>				       
							<li<?php if (page() == "admin") { ?> class="active"<?php } ?>><a href="admin.php">Logga in</a></li>
						<?php } ?>	
				    </ul>
				</div>