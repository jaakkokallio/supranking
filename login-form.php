<div class="span-12">
	<section id="login" class="span6 well">
		<?php if (isset($_GET["error"]) && $_GET["error"] == "login") { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Fel e-post eller lösenord!
			</div>
		<?php } ?>
		<form class="form-login" action="<?php echo URL_ROOT; ?>/login" method="post">
	    	<h2 class="form-login-heading">Logga in</h2>		
	        <input type="email" name="email" class="input-block-level" placeholder="E-post"<?php if (isset($_GET["email"])) { ?> value="<?php echo $_GET["email"]; ?>"<?php } ?> />
	        <input type="password" name="password" class="input-block-level" placeholder="Lösenord" />
	        <button class="btn btn-large btn-primary" type="submit">Logga in</button>
	    </form>
	</section>
</div>