<?php include("header.php"); ?>

<?php if (is_logged_in()) { ?>
	<?php $competition = get_competition_by_id($_GET["id"]); ?>
	<?php $female_competitor_names = competitor_names("female"); ?>
	<?php $male_competitor_names = competitor_names("male"); ?>
	
	<section class="span8 well">
		<h1>Administrera resultat</h1>
		<h2><?php echo $competition->name; ?> <?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></h2>
		<p class="lead"><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></p>
		<form action="/competition-results-update" method="post">
			
			<div class="results-spreadsheets">
				<h4>Damer Distans</h4>
				<div class="results-spreadsheet" id="female-distance-spreadsheet"></div>
				<h4>Damer Sprint</h4>
				<div class="results-spreadsheet" id="female-sprint-spreadsheet"></div>
				<h4>Herrar Distans</h4>
				<div class="results-spreadsheet" id="male-distance-spreadsheet"></div>
				<h4>Herrar Sprint</h4>
				<div class="results-spreadsheet" id="male-sprint-spreadsheet"></div>
			</div>
			
	        <button class="btn btn-large btn-primary" type="submit">Spara</button>
		</form>
	</section>
	
	<script type="text/javascript">
		window.competitors = {female: <?php echo json_encode($female_competitor_names); ?>, male: <?php echo json_encode($male_competitor_names); ?>};
		$("#female-distance-spreadsheet").spreadsheet("distance", "female");
		$("#female-sprint-spreadsheet").spreadsheet("sprint", "female");
		$("#male-distance-spreadsheet").spreadsheet("distance", "male");
		$("#male-sprint-spreadsheet").spreadsheet("sprint", "male");
	</script>

	<!-- New competitor modal -->
	<div class="modal hide fade admin-modal" id="new-competitor-modal" tabindex="-1" role="dialog" aria-hidden="true">
		
	</div>

<?php } else { ?>
	<?php include("login-form.php"); ?>
<?php } ?>

<?php include("footer.php"); ?>