<?php
	include("functions.php"); 
	
	$discipline = $_GET["discipline"];
	$gender = $_GET["gender"];
	$competitor_changes = $_GET["competitor_changes"];
?>

<div class="modal-dialog">
	<form action="/competitor-create" method="post" id="create-competitors">
		<input type="hidden" name="discipline" value="<?php echo $discipline; ?>" />
		<div class="modal-content new-competitor-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title">Lägg till deltagare</h2>
			</div>
			<div class="modal-body">
			<?php if (isset($_GET["error"])) { ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Följande deltagare kunde inte sparas!
				</div>
			<?php } ?>					
			<?php foreach ($competitor_changes as $i => $competitor_change) { ?>
				<?php
					$row = $competitor_change["row"];
					$competitor = $competitor_change["competitor"];
					$names = explode(" ", $competitor);
					$first_name = $names[0];
					$last_name = join(" ", array_slice($names, 1, sizeof($names)-1));
				?>
				<div class="new-competitor">
					<input type="hidden" name="competitor[<?php echo $i; ?>][row]" value="<?php echo $row; ?>" />
					<input type="hidden" name="competitor[<?php echo $i; ?>][gender]" value="<?php echo $gender; ?>" />
					<div>
						<input type="text" name="competitor[<?php echo $i; ?>][first_name]" placeholder="Förnamn" class="span10" value="<?php echo $first_name; ?>" />
					</div>
					<div>
						<input type="text" name="competitor[<?php echo $i; ?>][last_name]" placeholder="Efternamn" class="span10" value="<?php echo $last_name; ?>" />
					</div>
					<div>
						<select name="competitor[<?php echo $i; ?>][country]">
							<?php foreach (countries() as $code => $country) { ?>
								<option value="<?php echo $code; ?>"<?php if ($code == "SWE") { ?> selected="selected"<?php } ?>><?php echo $country; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			<?php } ?>
			</div>
			<div class="modal-footer">
				<a href="#" role="button" class="btn btn-primary submit-form">Spara</a>
			</div>
		</div>
	</form>
</div>
