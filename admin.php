<?php include("header.php"); ?>

<?php if (is_logged_in()) { ?>
	<section class="span12 well">
		<?php if (isset($_GET["error"])) { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php if ($_GET["error"] == "update-competition") { ?>
          <?php echo t("competition_information_could_not_be_saved"); ?>
				<?php } else if ($_GET["error"] == "create-competition") { ?>
          <?php echo t("competition_could_not_be_saved"); ?>
				<?php } else if ($_GET["error"] == "update-competitor") { ?>
          <?php echo t("participant_could_not_be_saved"); ?>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if (isset($_GET["success"])) { ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php if ($_GET["success"] == "update-competition") { ?>
          <?php echo t("competition_information_was_saved"); ?>
				<?php } else if ($_GET["success"] == "create-competition") { ?>
          <?php echo t("competition_was_saved"); ?>
				<?php } else if ($_GET["success"] == "update-competitor") { ?>
          <?php echo t("participant_saved"); ?>
				<?php } ?>
			</div>
		<?php } ?>
		<h2><?php echo t("competitions"); ?></h2>
		<?php $competitions = get_competitions(); ?>
		<?php if ($competitions && mysql_num_rows($competitions) > 0) { ?>
			<table class="table table-striped">
       			<tbody>
					<?php while ($competition = mysql_fetch_object($competitions)) { ?>
						<tr>
							<td><a href="<?php echo URL_ROOT; ?>/competition/<?php echo $competition->urlname; ?>"><?php echo $competition->name; ?></a></td>
			        		<td><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></td>
			            	<td class="nowrap"><?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></td>
			        		<td class="align_right">
			        			<div class="btn-group">
							    	<a href="#edit-competition-modal-<?php echo $competition->id; ?>" role="button" class="btn" data-toggle="modal"><?php echo t("edit"); ?></a>
							    	<a href="<?php echo URL_ROOT; ?>/competition-results/<?php echo $competition->id; ?>" role="button" class="btn"><?php echo t("results"); ?></a>
							    </div>
			        		</td>
						</tr>
						
						<!-- Edit competition modal -->
						<div class="modal hide fade admin-modal" id="edit-competition-modal-<?php echo $competition->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<form action="<?php echo URL_ROOT; ?>/competition-update" method="post">
									<input type="hidden" name="id" value="<?php echo $competition->id; ?>" />
									<div class="modal-content competitor-details">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h2 class="modal-title"><?php echo t("edit_competition"); ?></h2>
										</div>
										<div class="modal-body">
											<div>
												<input type="text" name="name" placeholder="<?php echo t("name"); ?>" class="span10" value="<?php echo $competition->name; ?>" />
											</div>
											<div>
												<input type="text" name="urlname" placeholder="<?php echo t("name_in_url"); ?>" class="span10" value="<?php echo $competition->urlname; ?>" />
											</div>
											<div class="input-append date" data-date="<?php echo substr($competition->start_date,0,10); ?>" data-date-format="yyyy-mm-dd">
											  <input tabindex="1" class="span10" size="16" type="text" name="start_date" value="<?php echo substr($competition->start_date,0,10); ?>" placeholder="<?php echo t("start_date"); ?>" />
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div>
											<div class="input-append date" data-date="<?php echo substr($competition->end_date,0,10); ?>" data-date-format="yyyy-mm-dd">
											  <input tabindex="1" class="span10" size="16" type="text" name="end_date" value="<?php echo substr($competition->end_date,0,10); ?>" placeholder="<?php echo t("end_date"); ?>" />
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div>
                      <?php if (has_discipline("sprint")) { ?>
  											<div>
  												<input type="number" name="sprint_length" placeholder="<?php echo t("sprint_km"); ?>" class="span4" step="any" value="<?php if ($competition->sprint_length > 0) { echo $competition->sprint_length; } ?>" />
  											</div>
                      <?php } ?>
                      <?php if (has_discipline("distance")) { ?>
  											<div>
  												<input type="number" name="distance_length" placeholder="<?php echo t("distance_km"); ?>" class="span4" step="any" value="<?php if ($competition->distance_length > 0) { echo $competition->distance_length; } ?>" />
  											</div>
                      <?php } ?>
                      <?php if (has_discipline("sprint")) { ?>
  											<div>
  												<input type="number" name="sprint_length_female" placeholder="<?php echo t("sprint_female_km"); ?>" class="span4" step="any" value="<?php if ($competition->sprint_length_female > 0) { echo $competition->sprint_length_female; } ?>" />
  											</div>
                      <?php } ?>
                      <?php if (has_discipline("distance")) { ?>
  											<div>
  												<input type="number" name="distance_length_female" placeholder="<?php echo t("distance_female_km"); ?>" class="span4" step="any" value="<?php if ($competition->distance_length_female > 0) { echo $competition->distance_length_female; } ?>" />
  											</div>
                      <?php } ?>
											<div>
												<label for="status_1_<?php echo $competition->id ?>" class="radio"><input type="radio" name="status" id="status_1_<?php echo $competition->id ?>" value="1"<?php if ($competition->status == 1) { ?> checked="checked"<?php } ?> /> <i class="icon-star"></i></label>
												<label for="status_2_<?php echo $competition->id ?>" class="radio"><input type="radio" name="status" id="status_2_<?php echo $competition->id ?>" value="2"<?php if ($competition->status == 2) { ?> checked="checked"<?php } ?> /> <i class="icon-star"></i><i class="icon-star"></i></label>
												<label for="status_3_<?php echo $competition->id ?>" class="radio"><input type="radio" name="status" id="status_3_<?php echo $competition->id ?>" value="3"<?php if ($competition->status == 3) { ?> checked="checked"<?php } ?> /> <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></label>
											</div>

											<div>
												<textarea name="description" rows="10" placeholder="<?php echo t("description"); ?>" class="span10"><?php echo $competition->description; ?></textarea>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary"><?php echo t("save"); ?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php } ?>
		    	</tbody>
			</table>
		<?php } ?>
        <a href="#new-competition-modal" role="button" class="btn btn-large btn-primary" data-toggle="modal"><?php echo t("add_competition"); ?></a>
		<!-- New competition modal -->
		<div class="modal hide fade admin-modal" id="new-competition-modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<form action="<?php echo URL_ROOT; ?>/competition-create" method="post">
					<div class="modal-content competitor-details">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h2 class="modal-title"><?php echo t("add_competition"); ?></h2>
						</div>
						<div class="modal-body">
							<div>
								<input type="text" name="name" placeholder="<?php echo t("name"); ?>" class="span10" />
							</div>
							<div>
								<input type="text" name="urlname" placeholder="<?php echo t("name_in_url"); ?>" class="span10" />
							</div>
							<div class="input-append date" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
							  <input tabindex="1" class="span10" size="16" type="text" name="start_date" value="<?php echo date("Y-m-d"); ?>" placeholder="<?php echo t("start_date"); ?>" />
							  <span class="add-on"><i class="icon-calendar"></i></span>
							</div>
							<div class="input-append date" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
							  <input tabindex="1" class="span10" size="16" type="text" name="end_date" value="<?php echo date("Y-m-d"); ?>" placeholder="<?php echo t("end_date"); ?>" />
							  <span class="add-on"><i class="icon-calendar"></i></span>
							</div>
              <?php if (has_discipline("sprint")) { ?>
  							<div>
  								<input type="number" name="sprint_length" placeholder="<?php echo t("sprint_km"); ?>" class="span4" step="any" />
  							</div>
              <?php } ?>
              <?php if (has_discipline("distance")) { ?>
  							<div>
  								<input type="number" name="distance_length" placeholder="<?php echo t("distance_km"); ?>" class="span4" step="any" />
  							</div>
              <?php } ?>
              <?php if (has_discipline("sprint")) { ?>
  							<div>
  								<input type="number" name="sprint_length_female" placeholder="<?php echo t("sprint_female_km"); ?>" class="span4" step="any" />
  							</div>
              <?php } ?>
              <?php if (has_discipline("distance")) { ?>
  							<div>
  								<input type="number" name="distance_length_female" placeholder="<?php echo t("distance_female_km"); ?>" class="span4" step="any" />
  							</div>
              <?php } ?>
							<div>
								<label for="status_1" class="radio"><input type="radio" name="status" id="status_1" value="1" /> <i class="icon-star"></i></label>
								<label for="status_2" class="radio"><input type="radio" name="status" id="status_2" value="2" checked="checked" /> <i class="icon-star"></i><i class="icon-star"></i></label>
								<label for="status_3" class="radio"><input type="radio" name="status" id="status_3" value="3" /> <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></label>
							</div>
							<div>
								<textarea name="description" rows="10" placeholder="<?php echo t("description"); ?>" class="span10"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"><?php echo t("save"); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<section class="span12 well">
		<h2><?php echo t("participants"); ?></h2>
		<?php $competitors = get_competitors(); ?>
		<?php if ($competitors && mysql_num_rows($competitors) > 0) { ?>
			<table class="table table-striped table-bordered admin-competitors-list">
                <thead>
                    <tr>
                        <th class="sorting"><?php echo t("id"); ?></th>
                        <th class="sorting"><?php echo t("first_name"); ?></th>
                        <th class="sorting"><?php echo t("last_name"); ?></th>
                        <th class="sorting"><?php echo t("gender"); ?></th>
                        <th class="sorting"><?php echo t("country"); ?></th>
						<th></th>
                    </tr>
                </thead>
       			<tbody>
					<?php while ($competitor = mysql_fetch_object($competitors)) { ?>
						<tr>
							<td><?php echo $competitor->id; ?></td>
							<td><a href="#" class="show-results" data-competitor-id="<?php echo $competitor->id; ?>"><?php echo $competitor->first_name; ?></a></td>
							<td><a href="#" class="show-results" data-competitor-id="<?php echo $competitor->id; ?>"><?php echo $competitor->last_name; ?></a></td>
			        		<td><?php echo readable_gender($competitor->gender); ?></td>
							<td><?php echo $competitor->country; ?></td>
							<td class="align_right">
			        			<div class="btn-group">
							    	<a href="#edit-competitor-modal-<?php echo $competitor->id; ?>" role="button" class="btn" data-toggle="modal"><?php echo t("edit"); ?></a>
							    </div>
			        		</td>
						</tr>
						
						<!-- Edit competitor modal -->
						<div class="modal hide fade admin-modal" id="edit-competitor-modal-<?php echo $competitor->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<form action="<?php echo URL_ROOT; ?>/competitor-update" method="post">
									<input type="hidden" name="id" value="<?php echo $competitor->id; ?>" />
									<div class="modal-content competitor-details">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h2 class="modal-title"><?php echo t("edit_participant"); ?></h2>
										</div>
										<div class="modal-body">
											<div>
												<input type="text" name="first_name" placeholder="<?php echo t("first_name"); ?>" class="span10" value="<?php echo $competitor->first_name; ?>" />
											</div>
											<div>
												<input type="text" name="last_name" placeholder="<?php echo t("last_name"); ?>" class="span10" value="<?php echo $competitor->last_name; ?>" />
											</div>
											<div>
												<label for="gender_male_<?php echo $competitor->id ?>" class="radio"><input type="radio" name="gender" id="gender_male_<?php echo $competitor->id ?>" value="male"<?php if ($competitor->gender == "male") { ?> checked="checked"<?php } ?> /> <?php echo t("man"); ?></label>
												<label for="gender_female_<?php echo $competitor->id ?>" class="radio"><input type="radio" name="gender" id="gender_female_<?php echo $competitor->id ?>" value="female"<?php if ($competitor->gender == "female") { ?> checked="checked"<?php } ?> /> <?php echo t("woman"); ?></label>
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
											<button type="submit" class="btn btn-primary"><?php echo t("save"); ?></button>
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
	<?php include("login-form.php"); ?>
<?php } ?>

<?php include("footer.php"); ?>