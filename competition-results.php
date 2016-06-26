<?php include("header.php"); ?>

<?php if (is_logged_in()) { ?>
	<?php 
		$competition = get_competition_by_id(id()); 
		
		$female_competitor_names = competitor_names("female");
		$male_competitor_names = competitor_names("male");
		
		$female_distance_results = results_for_spreadsheet($competition->id, "female", "distance");
		$female_sprint_results = results_for_spreadsheet($competition->id, "female", "sprint");
		$male_distance_results = results_for_spreadsheet($competition->id, "male", "distance");
		$male_sprint_results = results_for_spreadsheet($competition->id, "male", "sprint");
	?>
	
	<section class="span12 well">
		<h1>Administrera resultat</h1>
		<h2><?php echo $competition->name; ?> <?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></h2>
		<p class="lead"><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></p>
			
		<div class="results-spreadsheets">
      <?php if (has_discipline("distance")) { ?>
  			<h4>Damer Distans</h4>
  			<div class="results-spreadsheet" id="female-distance-spreadsheet"></div>
      <?php } ?>
      <?php if (has_discipline("sprint")) { ?>
  			<h4>Damer Sprint</h4>
  			<div class="results-spreadsheet" id="female-sprint-spreadsheet"></div>
      <?php } ?>
      <?php if (has_discipline("distance")) { ?>
  			<h4>Herrar Distans</h4>
  			<div class="results-spreadsheet" id="male-distance-spreadsheet"></div>
      <?php } ?>
      <?php if (has_discipline("sprint")) { ?>
  			<h4>Herrar Sprint</h4>
  			<div class="results-spreadsheet" id="male-sprint-spreadsheet"></div>
      <?php } ?>
		</div>
		
		<a href="#" role="button" class="btn btn-primary btn-large large save-results" data-competition-id="<?php echo $competition->id; ?>">Spara</a>
	</section>
	
	<script type="text/javascript">
		window.competitors = {female: <?php echo json_encode($female_competitor_names); ?>, male: <?php echo json_encode($male_competitor_names); ?>};
		<?php if (has_discipline("distance")) { ?>$("#female-distance-spreadsheet").spreadsheet("distance", "female", <?php echo $female_distance_results; ?>);<?php } ?>
		<?php if (has_discipline("sprint")) { ?>$("#female-sprint-spreadsheet").spreadsheet("sprint", "female", <?php echo $female_sprint_results; ?>);<?php } ?>
		<?php if (has_discipline("distance")) { ?>$("#male-distance-spreadsheet").spreadsheet("distance", "male", <?php echo $male_distance_results; ?>);<?php } ?>
		<?php if (has_discipline("sprint")) { ?>$("#male-sprint-spreadsheet").spreadsheet("sprint", "male", <?php echo $male_sprint_results; ?>);<?php } ?>
	</script>

	<!-- New competitor modal -->
	<div class="modal hide fade admin-modal" id="new-competitor-modal" tabindex="-1" role="dialog" aria-hidden="true">
		
	</div>

<?php } else { ?>
	<?php include("login-form.php"); ?>
<?php } ?>

<?php include("footer.php"); ?>