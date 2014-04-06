<section class="sidebar span4">
	<?php $upcoming_competitions = get_upcoming_competitions(); ?>
	<?php if ($upcoming_competitions && mysql_num_rows($upcoming_competitions) > 0) { ?>
		<aside class="upcoming-events well well-large">
	        <h3>Kommande tävlingar</h3>
	        <table class="table table-striped">
	            <tbody>
					<?php while ($competition = mysql_fetch_object($upcoming_competitions)) { ?>
						<tr>
		                    <td><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></td>
		                    <td><a href="/competition?id=<?php echo $competition->id; ?>"><?php echo $competition->name; ?></a></td>
		                    <td class="nowrap"><?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></td>
		                </tr>
					<?php } ?>
	            </tbody>
	        </table>
	    </aside>
	<?php } ?>
	<?php $previous_competitions = get_previous_competitions(); ?>
	<?php if ($previous_competitions && mysql_num_rows($previous_competitions) > 0) { ?>
		<aside class="earlier-events well well-large">
	        <h3>Tidigare tävlingar</h3>
	        <table class="table table-striped">
	            <tbody>
					<?php while ($competition = mysql_fetch_object($previous_competitions)) { ?>
						<tr>
		                    <td><?php echo readable_date_range(strtotime($competition->start_date), strtotime($competition->end_date)); ?></td>
		                    <td><a href="competition?id=<?php echo $competition->id; ?>"><?php echo $competition->name; ?></a></td>
		                    <td class="nowrap"><?php for ($i = 0 ; $i < $competition->status; $i++) { ?><i class="icon-star"></i><?php } ?></td>
		                </tr>
					<?php } ?>
	            </tbody>
	        </table>
	    </aside>
	<?php } ?>
</section>
