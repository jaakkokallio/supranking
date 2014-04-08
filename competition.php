<?php include("header.php"); ?>

<section id="competition" class="span7 well">
	
	<?php $competition = get_competition_by_id_or_urlname($_GET["id"]); ?>

	<h2><?php echo $competition->name; ?> <?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></h2>
	<p class="lead"><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></p>
	<p><?php echo nl2br($competition->description); ?></p>
	<?php $distance_results = get_results_by_competition($competition->id, "distance"); ?>
	<?php $sprint_results = get_results_by_competition($competition->id, "sprint"); ?>
	<?php if (($distance_results && mysql_num_rows($distance_results) > 0) || ($sprint_results && mysql_num_rows($sprint_results) > 0)) { ?>
		<h3>Resultat</h3>
		<?php if ($distance_results && mysql_num_rows($distance_results) > 0) { ?>
			<h4>Distans</h3>
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
	            	<?php while ($r = mysql_fetch_object($distance_results)) { ?>
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
		<?php if ($sprint_results && mysql_num_rows($sprint_results) > 0) { ?>
			<h4>Sprint</h3>
			<table class="table table-striped table-hover result-list">
				<thead>
					<tr>
						<th>#</th>
						<th>Namn</th>
						<th class="align_right">Tid</th>
					</tr>
				</thead>
				<tbody>
	            	<?php while ($r = mysql_fetch_object($sprint_results)) { ?>
						<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
							<td><?php echo $r->placing; ?></td>
							<td><?php echo $r->first_name; ?> <?php echo $r->last_name; ?><?php if ($r->country != "SWE") echo " <em>(".$r->country.")</em>"; ?></td>
							<td class="align_right"><?php echo readable_time($r->time); ?></td>
						</tr>
					<? } ?>
				</tbody>
			</table>
		<?php } ?>
	<?php } ?>
</section>

<!-- Competitor modal -->
<div class="modal fade" id="competitor-modal" tabindex="-1" role="dialog" aria-hidden="true">

</div>

<?php include("sidebar.php"); ?>

<?php include("footer.php"); ?>