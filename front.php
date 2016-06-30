<?php include("header.php"); ?>

<input type="hidden" name="gender" id="gender" value="Herrar"/>

<section id="ranking-list-container" class="span7 well">
    <header class="rl-menu">
        <div class="btn-group genderChoice" data-toggle="buttons-radio">   
            <button id="genderMaleBtn" class="btn active" value="Herrar" name="genderChoice"><?php echo t("men"); ?></button>
            <button id="genderFemaleBtn" class="btn" value="Damer" name="genderChoice"><?php echo t("females"); ?></button>
        </div>
    </header>
    <!-- Start male section -->
    <div id="genderMale" class="tabbable"> <!-- Only required for left/right tabs -->
        <?php if (count(disciplines()) > 1) { ?>
          <ul class="nav nav-tabs">
              <li class="active"><a href="#all" data-toggle="tab"><?php echo t("total"); ?></a></li>
              <?php if (has_discipline("distance")) { ?><li><a href="#distans" data-toggle="tab"><?php echo t("distance"); ?></a></li><?php } ?>
              <?php if (has_discipline("sprint")) { ?><li><a href="#sprint" data-toggle="tab"><?php echo t("sprint"); ?></a></li><?php } ?>
          </ul>
        <?php } ?>
        <div class="tab-content">
            <div class="tab-pane active" id="all">
                <table id="male-ranking-list" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">#</th>
                            <th class="sorting"><?php echo t("first_name"); ?></th>
                            <th class="sorting"><?php echo t("last_name"); ?></th>
                            <th class="sorting nowrap"><?php echo t("competitions"); ?> <?php if (count(disciplines()) > 1) { ?><small><?php echo t("distance_sprint"); ?></small><?php } ?></th>
                            <th class="sorting"><?php echo t("points"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php foreach (ranking("male") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php if (has_discipline("distance")) { echo $r->distance_competitions; } ?> <?php if (count(disciplines()) > 1) { echo "|"; } ?> <?php if (has_discipline("sprint")) { echo $r->sprint_competitions; } ?></td>
								<td><?php echo $r->points; ?></td>
							</tr>
						<? } ?>

                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="distans">
                <table id="male-ranking-list-distance" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
						<tr>
                            <th class="sorting">#</th>
                            <th class="sorting"><?php echo t("first_name"); ?></th>
                            <th class="sorting"><?php echo t("last_name"); ?></th>
                            <th class="sorting nowrap"><?php echo t("competitions"); ?></th>
                            <?php if (HAS_CLASSES) { ?><th class="sorting"><?php echo t("class"); ?></th><?php } ?>
                            <th class="sorting"><?php echo t("points"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php foreach (ranking("male", "distance") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?></td>
								<?php if (HAS_CLASSES) { ?><td><?php echo $r->class; ?></td><?php } ?>
								<td><?php echo $r->points; ?></td>
							</tr>
						<? } ?>

                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="sprint">
                <table id="male-ranking-list-sprint" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
						<tr>
                            <th class="sorting">#</th>
                            <th class="sorting"><?php echo t("first_name"); ?></th>
                            <th class="sorting"><?php echo t("last_name"); ?></th>
                            <th class="sorting nowrap"><?php echo t("competitions"); ?></th>
                            <th class="sorting"><?php echo t("points"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
	
						<?php foreach (ranking("male", "sprint") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->sprint_competitions; ?></td>
								<td><?php echo $r->points; ?></td>
							</tr>
						<? } ?>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End male section -->
    <!-- Start female section -->
    <div id="genderFemale" class="tabbable"> <!-- Only required for left/right tabs -->
        <?php if (count(disciplines()) > 1) { ?>
          <ul class="nav nav-tabs">
              <li class="active"><a href="#all_2" data-toggle="tab"><?php echo t("total"); ?></a></li>
              <?php if (has_discipline("distance")) { ?><li><a href="#distans_2" data-toggle="tab"><?php echo t("distance"); ?></a></li><?php } ?>
              <?php if (has_discipline("sprint")) { ?><li><a href="#sprint_2" data-toggle="tab"><?php echo t("sprint"); ?></a></li><?php } ?>
          </ul>
        <?php } ?>
        <div class="tab-content">
            <div class="tab-pane active" id="all_2">
                <table id="female-ranking-list" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">#</th>
                            <th class="sorting"><?php echo t("first_name"); ?></th>
                            <th class="sorting"><?php echo t("last_name"); ?></th>
                            <th class="sorting nowrap"><?php echo t("competitions"); ?><?php if (count(disciplines()) > 1) { ?> <small><?php echo t("distance_sprint"); ?></small><?php } ?></th>
                            <th class="sorting"><?php echo t("points"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php foreach (ranking("female") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php if (has_discipline("distance")) { echo $r->distance_competitions; } ?> <?php if (count(disciplines()) > 1) { echo "|"; } ?> <?php if (has_discipline("sprint")) { echo $r->sprint_competitions; } ?></td>
								<td><?php echo $r->points; ?></td>
							</tr>
						<? } ?>

                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="distans_2">
                <table id="female-ranking-list-distance" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">#</th>
                            <th class="sorting"><?php echo t("first_name"); ?></th>
                            <th class="sorting"><?php echo t("last_name"); ?></th>
                            <th class="sorting"><?php echo t("competitions"); ?></th>
                            <?php if (HAS_CLASSES) { ?><th class="sorting"><?php echo t("competitions"); ?></th><?php } ?>
                            <th class="sorting"><?php echo t("points"); ?></th>
                        </tr>
                    </thead>
                    <tbody>

						<?php foreach (ranking("female", "distance") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?></td>
								<?php if (HAS_CLASSES) { ?><td><?php echo $r->class; ?></td><?php } ?>
								<td><?php echo $r->points; ?></td>
							</tr>
						<? } ?>

                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="sprint_2">
                <table id="female-ranking-list-sprint" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">#</th>
                            <th class="sorting"><?php echo t("first_name"); ?></th>
                            <th class="sorting"><?php echo t("last_name"); ?></th>
                            <th class="sorting"><?php echo t("competitions"); ?></th>
                            <th class="sorting"><?php echo t("points"); ?></th>
                        </tr>
                    </thead>
                    <tbody>

						<?php foreach (ranking("female", "sprint") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->sprint_competitions; ?></td>
								<td><?php echo $r->points; ?></td>
							</tr>
						<? } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End female section -->
</section>

<?php include("sidebar.php"); ?>

<!-- Competitor modal -->
<div class="modal fade" id="competitor-modal" tabindex="-1" role="dialog" aria-hidden="true">

</div>


<?php include("footer.php"); ?>