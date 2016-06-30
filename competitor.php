<?php
	$competitor = get_competitor_by_id(id());
	
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
				<h3><?php echo t("distance"); ?></h3>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo t("competition"); ?></th>
							<?php if (HAS_CLASSES) { ?><th><?php echo t("class"); ?></th><?php } ?>
							<th class="align_right"><?php echo t("average_speed"); ?></th>
							<?php if (HAS_CLASSES) { ?>
								<th class="align_right nowrap"><span class="placing" data-toggle="popover" data-placement="top" data-content="<?php echo t("to_ju_tooltip"); ?>"><?php echo t("placing"); ?> <small><?php echo t("to_ju"); ?></small></span></th>
							<?php } else { ?>
								<th class="align_right"><?php echo t("placing"); ?></th>
							<?php } ?>
							<th class="align_right"><?php echo t("points"); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($results->distance_results as $result) { ?>
							<tr>
								<td><?php echo $result->name; ?></td>
								<?php if (HAS_CLASSES) { ?><td><?php echo readable_class($result->class); ?></td><?php } ?>
								<?php $length = competition_length($result, $competitor->gender, "distance"); ?>
								<td class="align_right"><?php echo readable_velocity($result->time, $length); ?></td>							
								<td class="align_right"><?php if (HAS_CLASSES) { ?>
<?php echo $result->placing; ?> | <?php } ?><?php echo $result->adjusted_placing; ?></td>
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
							<th><?php echo t("competition"); ?></th>
							<th class="align_right"><?php echo t("average_speed"); ?></th>
							<th class="align_right"><?php echo t("placing"); ?></th>							
							<th class="align_right"><?php echo t("points"); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($results->sprint_results as $result) { ?>
							<tr>
								<td><?php echo $result->name; ?></td>
								<?php $length = competition_length($result, $competitor->gender, "sprint"); ?>
								<td class="align_right"><?php echo readable_velocity($result->time, $length); ?></td>								
								<td class="align_right"><?php echo $result->adjusted_placing; ?></td>
								<td class="align_right<?php if (!$result->points_added_to_sum) echo " points_not_added_to_sum"; ?>"><?php echo $result->points; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
		<div class="modal-footer">
			<div class="clearfix">
				<h4><?php echo t("points"); ?></h4>
        <?php if (count(disciplines()) > 1) { ?>
  				<?php if (sizeof($results->sprint_results) > 0) { ?><p><span class="badge"><?php echo $results->sprint_points; ?></span> <em><?php echo t("sprint"); ?></em></p><?php } ?>
  				<?php if (sizeof($results->distance_results) > 0) { ?><p><span class="badge"><?php echo $results->distance_points; ?></span> <em><?php echo t("distance"); ?></em></p><?php } ?>
        <?php } ?>
		    	<?php if (isset($results->points)) { ?><p><span class="badge"><?php echo $results->points; ?></span> <em><?php echo t("total"); ?></em></p><?php } ?>
			</div>
			<div class="clearfix">
				<h4><?php echo t("ranking"); ?></h4>
        <?php if (count(disciplines()) > 1) { ?>
  				<?php if (sizeof($results->sprint_results) > 0) { ?><p><span class="badge"><?php echo $results->sprint_placing; ?></span> <em><?php echo t("sprint"); ?></em></p><?php } ?>
  				<?php if (sizeof($results->distance_results) > 0) { ?><p><span class="badge"><?php echo $results->distance_placing; ?></span> <em><?php echo t("distance"); ?></em></p><?php } ?>
        <?php } ?>
				<?php if (isset($results->placing)) { ?><p><span class="badge"><?php echo $results->placing; ?></span> <em><?php echo t("total"); ?></em></p><?php } ?>
			</div>
		</div>
	</div>
</div>