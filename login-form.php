<div class="span-12">
	<section id="login" class="span6 well">
		<?php if (isset($_GET["error"]) && $_GET["error"] == "login") { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo t("wrong_email_or_password"); ?>
			</div>
		<?php } ?>
		<form class="form-login" action="<?php echo URL_ROOT; ?>/login" method="post">
	    	<h2 class="form-login-heading"><?php echo t("login"); ?></h2>		
	        <input type="email" name="email" class="input-block-level" placeholder="<?php echo t("email"); ?>"<?php if (isset($_GET["email"])) { ?> value="<?php echo $_GET["email"]; ?>"<?php } ?> />
	        <input type="password" name="password" class="input-block-level" placeholder="<?php echo t("password"); ?>" />
	        <button class="btn btn-large btn-primary" type="submit">Logga in</button>
	    </form>
	</section>
</div>