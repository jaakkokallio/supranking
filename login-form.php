<div class="span-12">
	<section id="login" class="span6 well">
		<?php if (isset($_GET["error"]) && $_GET["error"] == "login") { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Fel användarnamn eller lösenord!
			</div>
		<?php } ?>
		<form class="form-login" action="/login" method="post">
	    	<h2 class="form-login-heading">Logga in</h2>		
	        <input type="text" name="username" class="input-block-level" placeholder="Username">
	        <input type="password" name="password" class="input-block-level" placeholder="Password">
	        <button class="btn btn-large btn-primary" type="submit">Logga in</button>
	    </form>
	</section>
</div>