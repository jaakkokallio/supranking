<?php include("header.php"); ?>

<?php if (is_logged_in()) { ?>
	<section class="span12 well">
		<?php if (isset($_GET["error"])) { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php if ($_GET["error"] == "update-competition") { ?>
					Tävlingsinformationen kunde inte sparas!
				<?php } else if ($_GET["error"] == "create-competition") { ?>
					Tävlingen kunde inte sparas!
				<?php } else if ($_GET["error"] == "update-competitor") { ?>
					Deltagarinformationen kunde inte sparas!
				<?php } ?>
			</div>
		<?php } ?>
		<?php if (isset($_GET["success"])) { ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php if ($_GET["success"] == "update-competition") { ?>
					Tävlingsinformationen sparades!
				<?php } else if ($_GET["success"] == "create-competition") { ?>
					Tävlingen sparades!
				<?php } else if ($_GET["success"] == "update-competitor") { ?>
					Deltagarinformationen sparades!
				<?php } ?>
			</div>
		<?php } ?>
		<h2>Tävlingar</h2>
		<?php $competitions = get_competitions(); ?>
		<?php if ($competitions && mysql_num_rows($competitions) > 0) { ?>
			<table class="table table-striped">
       			<tbody>
					<?php while ($competition = mysql_fetch_object($competitions)) { ?>
						<tr>
							<td><a href="/competition/<?php echo $competition->urlname; ?>"><?php echo $competition->name; ?></a></td>
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
								<form action="/competition-update" method="post">
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
											<div>
												<input type="text" name="urlname" placeholder="Namn i URL" class="span10" value="<?php echo $competition->urlname; ?>" />
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
												<label for="status_1_<?php echo $competition->id ?>" class="radio"><input type="radio" name="status" id="status_1_<?php echo $competition->id ?>" value="1"<?php if ($competition->status == 1) { ?> checked="checked"<?php } ?> /> <i class="icon-star"></i></label>
												<label for="status_2_<?php echo $competition->id ?>" class="radio"><input type="radio" name="status" id="status_2_<?php echo $competition->id ?>" value="2"<?php if ($competition->status == 2) { ?> checked="checked"<?php } ?> /> <i class="icon-star"></i><i class="icon-star"></i></label>
												<label for="status_3_<?php echo $competition->id ?>" class="radio"><input type="radio" name="status" id="status_3_<?php echo $competition->id ?>" value="3"<?php if ($competition->status == 3) { ?> checked="checked"<?php } ?> /> <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></label>
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
        <a href="#new-competition-modal" role="button" class="btn btn-large btn-primary" data-toggle="modal">Lägg till tävling</a>
		<!-- New competition modal -->
		<div class="modal hide fade admin-modal" id="new-competition-modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<form action="/competition-create" method="post">
					<div class="modal-content competitor-details">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h2 class="modal-title">Lägg till tävling</h2>
						</div>
						<div class="modal-body">
							<div>
								<input type="text" name="name" placeholder="Namn" class="span10" />
							</div>
							<div class="input-append date" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
							  <input tabindex="1" class="span10" size="16" type="text" name="start_date" value="<?php echo date("Y-m-d"); ?>" placeholder="Startdatum" />
							  <span class="add-on"><i class="icon-calendar"></i></span>
							</div>
							<div class="input-append date" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
							  <input tabindex="1" class="span10" size="16" type="text" name="end_date" value="<?php echo date("Y-m-d"); ?>" placeholder="Slutdatum" />
							  <span class="add-on"><i class="icon-calendar"></i></span>
							</div>
							<div>
								<label for="status_1" class="radio"><input type="radio" name="status" id="status_1" value="1" /> <i class="icon-star"></i></label>
								<label for="status_2" class="radio"><input type="radio" name="status" id="status_2" value="2" checked="checked" /> <i class="icon-star"></i><i class="icon-star"></i></label>
								<label for="status_3" class="radio"><input type="radio" name="status" id="status_3" value="3" /> <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></label>
							</div>
							<div>
								<textarea name="description" rows="10" placeholder="Beskrivning" class="span10"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Spara</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<section class="span12 well">
		<h2>Deltagare</h2>
		<?php $competitors = get_competitors(); ?>
		<?php if ($competitors && mysql_num_rows($competitors) > 0) { ?>
			<table class="table table-striped table-bordered admin-competitors-list">
                <thead>
                    <tr>
                        <th class="sorting">ID</th>
                        <th class="sorting">Förnamn</th>
                        <th class="sorting">Efternamn</th>
                        <th class="sorting">Kön</th>
                        <th class="sorting">Land</th>
						<th></th>
                    </tr>
                </thead>
       			<tbody>
					<?php while ($competitor = mysql_fetch_object($competitors)) { ?>
						<tr>
							<td><?php echo $competitor->id; ?></td>
							<td><?php echo $competitor->first_name; ?></td>
							<td><?php echo $competitor->last_name; ?></td>
			        		<td><?php echo readable_gender($competitor->gender); ?></td>
							<td><?php echo $competitor->country; ?></td>
							<td class="align_right">
			        			<div class="btn-group">
							    	<a href="#edit-competitor-modal-<?php echo $competitor->id; ?>" role="button" class="btn" data-toggle="modal">Redigera</a>
							    	<a href="#" role="button" class="btn show-results" data-competitor-id="<?php echo $competitor->id; ?>">Resultat</a>
							    </div>
			        		</td>
						</tr>
						
						<!-- Edit competitor modal -->
						<div class="modal hide fade admin-modal" id="edit-competitor-modal-<?php echo $competitor->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<form action="/competitor-update" method="post">
									<input type="hidden" name="id" value="<?php echo $competitor->id; ?>" />
									<div class="modal-content competitor-details">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h2 class="modal-title">Redigera deltagarinformation</h2>
										</div>
										<div class="modal-body">
											<div>
												<input type="text" name="first_name" placeholder="Förnamn" class="span10" value="<?php echo $competitor->first_name; ?>" />
											</div>
											<div>
												<input type="text" name="last_name" placeholder="Efternamn" class="span10" value="<?php echo $competitor->last_name; ?>" />
											</div>
											<div>
												<label for="gender_male_<?php echo $competitor->id ?>" class="radio"><input type="radio" name="gender" id="gender_male_<?php echo $competitor->id ?>" value="male"<?php if ($competitor->gender == "male") { ?> checked="checked"<?php } ?> /> Man</label>
												<label for="gender_female_<?php echo $competitor->id ?>" class="radio"><input type="radio" name="gender" id="gender_female_<?php echo $competitor->id ?>" value="female"<?php if ($competitor->gender == "female") { ?> checked="checked"<?php } ?> /> Kvinna</label>
											</div>
											<div>
												<select name="country">
													<?php foreach (countries() as $code => $country) { ?>
														<option value="<?php echo $code; ?>"<?php if ($competitor->country == $code) { ?> selected="selected"<?php } ?>><?php echo $country; ?></option>
													<?php } ?>
												</select>
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
	
	<!-- Competitor modal -->
	<div class="modal fade" id="competitor-modal" tabindex="-1" role="dialog" aria-hidden="true">

	</div>
	
<?php } else { ?>
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
<?php } ?>

<?php include("footer.php"); ?>