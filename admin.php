<?php include("header.php"); ?>

<?php if (is_logged_in()) { ?>
	<section id="admin" class="span12 well">
		<?php if (isset($_GET["error"]) && $_GET["error"] == "update-competition") { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Tävlingsinformationen kunde inte sparas!
			</div>
		<?php } ?>
		<?php if (isset($_GET["success"]) && $_GET["success"] == "update-competition") { ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Tävlingsinformationen sparades!
			</div>
		<?php } ?>
		<h2>Tävlingar</h2>
		<?php $competitions = get_competitions(); ?>
		<?php if ($competitions && mysql_num_rows($competitions) > 0) { ?>
			<table class="table table-striped">
       			<tbody>
					<?php while ($competition = mysql_fetch_object($competitions)) { ?>
						<tr>
							<td><a href="competition.php?id=<?php echo $competition->id; ?>"><?php echo $competition->name; ?></a></td>
			        		<td><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></td>
			            	<td class="nowrap"><?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></td>
			        		<td class="align_right">
			        			<div class="btn-group">
							    	<a href="#edit-competition-modal-<?php echo $competition->id; ?>" role="button" class="btn" data-toggle="modal">Redigera</a>
							    	<a href="#" role="button" class="btn">Rapportera</a>
							    </div>
			        		</td>
						</tr>
						
						<!-- Edit competition modal -->
						<div class="modal hide fade admin-modal" id="edit-competition-modal-<?php echo $competition->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<form action="update-competition.php" method="post">
									<input type="hidden" name="id" value="<?php echo $competition->id; ?>" />
									<div class="modal-content competitor-details">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h2 class="modal-title">Redigera tävling</h2>
										</div>
										<div class="modal-body">
											<div>
												<input type="text" name="name" placeholder="Namn" class="span10" value="<?php echo $competition->name; ?>" />
											</div>
											<div class="input-append date" data-date="<?php echo substr($competition->start_date,0,10); ?>" data-date-format="yyyy-mm-dd">
											  <input tabindex="1" class="span10" size="16" type="text" name="start_date" value="<?php echo substr($competition->start_date,0,10); ?>" placeholder="Startdatum" />
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div>
											<div class="input-append date" data-date="<?php echo substr($competition->end_date,0,10); ?>" data-date-format="yyyy-mm-dd">
											  <input tabindex="1" class="span10" size="16" type="text" name="end_date" value="<?php echo substr($competition->end_date,0,10); ?>" placeholder="Slutdatum" />
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div>
											<div>
												<textarea name="description" rows="10" placeholder="Beskrivning" class="span10"><?php echo $competition->description; ?></textarea>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary">Spara</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php } ?>
		    	</tbody>
			</table>
		<?php } ?>
	</section>
<?php } else { ?>
	<div class="span-12">
	<section id="login" class="span6 well">
		<?php if (isset($_GET["error"]) && $_GET["error"] == "login") { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Fel användarnamn eller lösenord!
			</div>
		<?php } ?>
		<form class="form-login" action="login.php" method="post">
	    	<h2 class="form-login-heading">Logga in</h2>		
	        <input type="text" name="username" class="input-block-level" placeholder="Username">
	        <input type="password" name="password" class="input-block-level" placeholder="Password">
	        <button class="btn btn-large btn-primary" type="submit">Logga in</button>
	    </form>
	</section>
	</div>
<?php } ?>

<?php include("footer.php"); ?>