<?php include("header.php"); ?>

<input type="hidden" name="gender" id="gender" value="Herrar"/>

<section id="ranking-list-container" class="span7 well">
    <header class="rl-menu">
        <div class="btn-group genderChoice" data-toggle="buttons-radio">   
            <button id="genderMaleBtn" class="btn active" value="Herrar" name="genderChoice">Herrar</button>
            <button id="genderFemaleBtn" class="btn" value="Damer" name="genderChoice">Damer</button>
        </div>
    </header>
    <!-- Start male section -->
    <div id="genderMale" class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#all" data-toggle="tab">Total</a></li>
            <li><a href="#distans" data-toggle="tab">Distans</a></li>
            <li><a href="#sprint" data-toggle="tab">Sprint</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="all">
                <table id="male-ranking-list" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">#</th>
                            <th class="sorting">Förnamn</th>
                            <th class="sorting">Efternamn</th>
                            <th class="sorting nowrap">Tävlingar <span>(distans | sprint)</span></th>
                            <th class="sorting">Poäng</th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php foreach (ranking("male") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?> | <?php echo $r->sprint_competitions; ?></td>
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
                            <th class="sorting">Förnamn</th>
                            <th class="sorting">Efternamn</th>
                            <th class="sorting nowrap">Tävlingar</th>
                            <th class="sorting">Klass</th>
                            <th class="sorting">Poäng</th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php foreach (ranking("male", "distance") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?></td>
								<td><?php echo $r->class; ?></td>
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
                            <th class="sorting">Förnamn</th>
                            <th class="sorting">Efternamn</th>
                            <th class="sorting nowrap">Tävlingar</th>
                            <th class="sorting">Poäng</th>
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
        <ul class="nav nav-tabs">
            <li class="active"><a href="#all_2" data-toggle="tab">Total</a></li>
            <li><a href="#distans_2" data-toggle="tab">Distans</a></li>
            <li><a href="#sprint_2" data-toggle="tab">Sprint</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="all_2">
                <table id="female-ranking-list" class="table table-striped table-bordered ranking-list table-hover">
                    <thead>
                        <tr>
                            <th class="sorting">#</th>
                            <th class="sorting">Förnamn</th>
                            <th class="sorting">Efternamn</th>
                            <th class="sorting">Tävlingar</th>
                            <th class="sorting">Poäng</th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php foreach (ranking("female") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?> | <?php echo $r->sprint_competitions; ?></td>
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
                            <th class="sorting">Förnamn</th>
                            <th class="sorting">Efternamn</th>
                            <th class="sorting">Tävlingar</th>
                            <th class="sorting">Poäng</th>
                        </tr>
                    </thead>
                    <tbody>

						<?php foreach (ranking("female", "distance") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?> | <?php echo $r->sprint_competitions; ?></td>
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
                            <th class="sorting">Förnamn</th>
                            <th class="sorting">Efternamn</th>
                            <th class="sorting">Tävlingar</th>
                            <th class="sorting">Poäng</th>
                        </tr>
                    </thead>
                    <tbody>

						<?php foreach (ranking("female", "sprint") as $r) { ?>
							<tr data-competitor-id="<?php echo $r->competitor_id; ?>">
								<td><?php echo $r->placing; ?></td>
								<td><?php echo $r->first_name; ?></td>
								<td><?php echo $r->last_name; ?></td>
								<td><?php echo $r->distance_competitions; ?> | <?php echo $r->sprint_competitions; ?></td>
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