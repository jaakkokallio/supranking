<?php include("header.php"); ?>

<div class="span7">

	<section id="competition" class="well">

		<?php $competition = get_competition_by_id_or_urlname($_GET["id"]); ?>

		<h1><?php echo $competition->name; ?> <?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></h1>
		<p class="lead"><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></p>
		<p><?php echo nl2br($competition->description); ?></p>

	</section>

	<?php $male_distance_results = get_results_by_competition($competition->id, "male", "distance"); ?>
	<?php $male_sprint_results = get_results_by_competition($competition->id, "male", "sprint"); ?>
	<?php $female_distance_results = get_results_by_competition($competition->id, "female", "distance"); ?>
	<?php $female_sprint_results = get_results_by_competition($competition->id, "female", "sprint"); ?>

	<?php if (($female_distance_results && mysql_num_rows($female_distance_results) > 0) || ($female_sprint_results && mysql_num_rows($female_sprint_results) > 0)) { ?>
		<section id="competition-female-results" class="well">
			<h2>Resultat: Damer</h2>
			<?php if ($female_distance_results && mysql_num_rows($female_distance_results) > 0) { ?>
				<h3>Distans</h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<th>Klass</th>
							<th class="align_right">Tid</th>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($female_distance_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<td><?php echo readable_class($r->class); ?></td>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<?php } ?>
			<?php if ($female_sprint_results && mysql_num_rows($female_sprint_results) > 0) { ?>
				<h3>Sprint</h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<th class="align_right">Tid</th>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($female_sprint_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
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
				<h3>Distans</h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<th>Klass</th>
							<th class="align_right">Tid</th>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($male_distance_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<td><?php echo readable_class($r->class); ?></td>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<?php } ?>
			<?php if ($male_sprint_results && mysql_num_rows($male_sprint_results) > 0) { ?>
				<h3>Sprint</h3>
				<table class="table table-striped table-hover result-list">
					<thead>
						<tr>
							<th>#</th>
							<th>Namn</th>
							<th class="align_right">Tid</th>
						</tr>
					</thead>
					<tbody>
		            	<?php while ($r = mysql_fetch_object($male_sprint_results)) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
								<td class="align_right"><?php echo readable_time($r->time); ?></td>
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