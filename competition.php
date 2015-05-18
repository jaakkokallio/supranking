<?php include("header.php"); ?>

<div class="span7">

	<section id="competition" class="well">

		<?php $competition = get_competition_by_id_or_urlname($_GET["id"]); ?>

		<h1><?php echo $competition->name; ?> <?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></h1>
		<p class="lead"><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></p>
		<p><?php echo $competition->description; ?></p>

	</section>

	<?php $male_distance_results = get_results_by_competition($competition->id, "male", "distance"); ?>
	<?php $male_sprint_results = get_results_by_competition($competition->id, "male", "sprint"); ?>
	<?php $female_distance_results = get_results_by_competition($competition->id, "female", "distance"); ?>
	<?php $female_sprint_results = get_results_by_competition($competition->id, "female", "sprint"); ?>

	<?php if (($female_distance_results && mysql_num_rows($female_distance_results) > 0) || ($female_sprint_results && mysql_num_rows($female_sprint_results) > 0)) { ?>
		<section id="competition-female-results" class="well">
			<h2>Resultat: Damer</h2>
			<?php if ($female_distance_results && mysql_num_rows($female_distance_results) > 0) { ?>
				<?php $length = competition_length($competition, "female", "distance"); ?>
				<?php $readable_length = readable_competition_length($competition, "female", "distance"); ?>
				<h3>Distans <?php if ($readable_length != "") { echo "(".$readable_length.")"; } ?></h3>
				<?php $winner_time = mysql_fetch_object($female_distance_results)->time; ?>
				<?php mysql_data_seek($female_distance_results, 0); ?>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<?php if (HAS_CLASSES) { ?><th>Klass</th><?php } ?>
							<?php if ($length != 0) { ?>
								<th class="align_right">Snitthastighet</th>
							<?php } ?>
							<th class="align_right">Tid</th>
							<?php if ($winner_time > 0) { ?>
								<th class="align_right">Diff</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($female_distance_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<?php if (HAS_CLASSES) { ?><td><?php echo readable_class($r->class); ?></td><?php } ?>
								<?php if ($length != 0) { ?>
									<td class="align_right"><?php echo readable_velocity($r->time, $length); ?></td>								
								<?php } ?>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
								<?php if ($winner_time > 0) { ?>
									<td class="align_right"><?php echo readable_diff($winner_time, $r->time); ?></td>
								<?php } ?>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<?php } ?>
			<?php if ($female_sprint_results && mysql_num_rows($female_sprint_results) > 0) { ?>
				<?php $winner_time = mysql_fetch_object($female_sprint_results)->time; ?>
				<?php mysql_data_seek($female_sprint_results, 0); ?>
				<?php $length = competition_length($competition, "female", "sprint"); ?>
				<?php $readable_length = readable_competition_length($competition, "female", "sprint"); ?>
				<h3>Sprint <?php if ($readable_length != "") { echo "(".$readable_length.")"; } ?></h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<?php if ($length != 0) { ?>
								<th class="align_right">Snitthastighet</th>
							<?php } ?>
							<th class="align_right">Tid</th>
							<?php if ($winner_time > 0) { ?>
								<th class="align_right">Diff</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($female_sprint_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<?php if ($length != 0) { ?>
									<td class="align_right"><?php echo readable_velocity($r->time, $length); ?></td>								
								<?php } ?>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
								<?php if ($winner_time > 0) { ?>
									<td class="align_right"><?php echo readable_diff($winner_time, $r->time); ?></td>
								<?php } ?>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<?php } ?>
		</section>
	<?php } ?>

	<?php if (($male_distance_results && mysql_num_rows($male_distance_results) > 0) || ($male_sprint_results && mysql_num_rows($male_sprint_results) > 0)) { ?>
		<section id="competition-female-results" class="well">
			<h2>Resultat: Herrar</h2>
			<?php if ($male_distance_results && mysql_num_rows($male_distance_results) > 0) { ?>
				<?php $winner_time = mysql_fetch_object($male_distance_results)->time; ?>							
				<?php mysql_data_seek($male_distance_results, 0); ?>
				<?php $length = competition_length($competition, "male", "distance"); ?>
				<?php $readable_length = readable_competition_length($competition, "male", "distance"); ?>
				<h3>Distans <?php if ($readable_length != "") { echo "(".$readable_length.")"; } ?></h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<?php if (HAS_CLASSES) { ?><th>Klass</th><?php } ?>
							<?php if ($length != 0) { ?>
								<th class="align_right">Snitthastighet</th>
							<?php } ?>
							<th class="align_right">Tid</th>
							<?php if ($winner_time > 0) { ?>
								<th class="align_right">Diff</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($male_distance_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<?php if (HAS_CLASSES) { ?><td><?php echo readable_class($r->class); ?></td><?php } ?>
								<?php if ($length != 0) { ?>
									<td class="align_right"><?php echo readable_velocity($r->time, $length); ?></td>
								<?php } ?>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
								<?php if ($winner_time > 0) { ?>
									<td class="align_right"><?php echo readable_diff($winner_time, $r->time); ?></td>
								<?php } ?>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<?php } ?>
			<?php if ($male_sprint_results && mysql_num_rows($male_sprint_results) > 0) { ?>
				<?php $winner_time = mysql_fetch_object($male_sprint_results)->time; ?>
				<?php mysql_data_seek($male_sprint_results, 0); ?>			
				<?php $length = competition_length($competition, "male", "sprint"); ?>
				<?php $readable_length = readable_competition_length($competition, "male", "sprint"); ?>
				<h3>Sprint <?php if ($readable_length != "") { echo "(".$readable_length.")"; } ?></h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<?php if ($length != 0) { ?>
								<th class="align_right">Snitthastighet</th>
							<?php } ?>
							<th class="align_right">Tid</th>
							<?php if ($winner_time > 0) { ?>
								<th class="align_right">Diff</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($male_sprint_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<?php if ($length != 0) { ?>
									<td class="align_right"><?php echo readable_velocity($r->time, $length); ?></td>								
								<?php } ?>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
								<?php if ($winner_time > 0) { ?>
									<td class="align_right"><?php echo readable_diff($winner_time, $r->time); ?></td>
								<?php } ?>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<?php } ?>
		</section>
	<?php } ?>

</div>

<!-- Competitor modal -->
<div class="modal fade" id="competitor-modal" tabindex="-1" role="dialog" aria-hidden="true">

</div>

<?php include("sidebar.php"); ?>

<?php include("footer.php"); ?>