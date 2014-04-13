<?php
	include("functions.php"); 

	$competitor = get_competitor_by_id($_GET["competitor_id"]);
	
	$results = results_by_competitor($competitor);
?>

<div class="modal-dialog">
	<div class="modal-content competitor-details">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h2 class="modal-title"><?php echo $competitor->first_name ?> <?php echo $competitor->last_name ?> <?php if ($competitor->country != "SWE") echo " <em>(".$competitor->country.")</em>"; ?></h2>
		</div>
		<div class="modal-body">
			<?php if (sizeof($results->distance_results) > 0) { ?>
				<h3>Distans</h3>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Tävling</th>
							<th>Klass</th>
							<th class="align_right">Tid</th>
							<th class="align_right nowrap"><span class="placing" data-toggle="popover" data-placement="top" data-content="to: placering totalt, ju: placering justerad för klasser">Placering <small>(to | ju)</small></span></th>
							<th class="align_right">Poäng</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($results->distance_results as $result) { ?>
							<tr>
								<td><?php echo $result->name; ?></td>
								<td><?php echo readable_class($result->class); ?></td>
								<td class="align_right"><?php echo readable_time($result->time); ?></td>
								<td class="align_right"><?php echo $result->placing; ?> | <?php echo $result->adjusted_placing; ?></td>
								<td class="align_right<?php if (!$result->points_added_to_sum) echo " points_not_added_to_sum"; ?>"><?php echo $result->points; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
			<?php if (sizeof($results->sprint_results) > 0) { ?>
				<h3>Sprint</h3>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Tävling</th>
							<th class="align_right">Tid</th>
							<th class="align_right nowrap"><span class="placing" data-toggle="tooltip" data-placement="top" data-content="to: placering totalt, ju: placering justerad för klasser">Placering <small>(to | ju)</small></span></th>
							<th class="align_right">Poäng</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($results->sprint_results as $result) { ?>
							<tr>
								<td><?php echo $result->name; ?></td>
								<td class="align_right"><?php echo readable_time($result->time); ?></td>
								<td class="align_right"><?php echo $result->placing; ?> | <?php echo $result->adjusted_placing; ?></td>
								<td class="align_right<?php if (!$result->points_added_to_sum) echo " points_not_added_to_sum"; ?>"><?php echo $result->points; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
		<?php if ($competitor->country == "SWE") { ?>	
			<div class="modal-footer">
				<div class="clearfix">
					<h4>Poäng</h4>
					<?php if (sizeof($results->sprint_results) > 0) { ?><p><span class="badge"><?php echo $results->sprint_points; ?></span> <em>Sprint</em></p><?php } ?>
					<?php if (sizeof($results->distance_results) > 0) { ?><p><span class="badge"><?php echo $results->distance_points; ?></span> <em>Distans</em></p><?php } ?>
			    	<?php if (isset($results->points)) { ?><p><span class="badge"><?php echo $results->points; ?></span> <em>Total</em></p><?php } ?>
				</div>
				<div class="clearfix">
					<h4>Ranking</h4>
					<?php if (sizeof($results->sprint_results) > 0) { ?><p><span class="badge"><?php echo $results->sprint_placing; ?></span> <em>Sprint</em></p><?php } ?>
					<?php if (sizeof($results->distance_results) > 0) { ?><p><span class="badge"><?php echo $results->distance_placing; ?></span> <em>Distans</em></p><?php } ?>
					<?php if (isset($results->placing)) { ?><p><span class="badge"><?php echo $results->placing; ?></span> <em>Total</em></p><?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>