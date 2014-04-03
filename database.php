<?php	
	$connection = mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die ("Could not connect to the server.");
	mysql_select_db(DATABASE_DATABASE) or die ("Could not connect to the database.");
	mysql_set_charset('utf8');
	
	function install() {
		$query = "CREATE TABLE `competitions` (
		`id` INT NOT NULL AUTO_INCREMENT ,
		`start_date` date NOT NULL default '0000-00-00',
		`end_date` date NOT NULL default '0000-00-00',
		`name` VARCHAR(255) NOT NULL,
		`description` TEXT NOT NULL,
		`status` bigint NOT NULL default '0',
		PRIMARY KEY (`id`)
		);";
		$result = mysql_query($query);
		echo $query . "<br />";
		$query = "CREATE TABLE `competitors` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`first_name` VARCHAR(255) NOT NULL,
		`last_name` VARCHAR(255) NOT NULL,
		`gender` VARCHAR(255) NOT NULL,
		`country` VARCHAR(255) NOT NULL,
		PRIMARY KEY (`id`)
		);";
		$result = mysql_query($query);
		echo $query . "<br />";
		$query = "CREATE TABLE `results` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`competition_id` bigint NOT NULL default '0',
		`competitor_id` bigint NOT NULL default '0',
		`discipline` VARCHAR(255) NOT NULL,
		`class` VARCHAR(255) NOT NULL,
		`placing` bigint NOT NULL default '0',
		`time` bigint NOT NULL default '0',
		PRIMARY KEY (`id`)
		);";
		$result = mysql_query($query);
		echo $query . "<br />";
	}	
	
	function get_competitions() {
		$query = "SELECT * FROM competitions ORDER BY start_date ASC;";
		return mysql_query($query);
	}
	
	function get_upcoming_competitions() {
		$query = "SELECT * FROM competitions WHERE start_date > NOW() ORDER BY start_date ASC;";
		return mysql_query($query);
	}
	
	function get_previous_competitions() {
		$query = "SELECT * FROM competitions WHERE end_date < NOW() ORDER BY start_date ASC;";
		return mysql_query($query);
	}
	
	function update_competition($id, $name, $start_date, $end_date, $description) {
		if (isset($id) && isset($name) && isset($start_date) && isset($end_date) && isset($description) && $id != "" && $name != "" && $start_date != "" && $end_date != "" && $description != "") {
			$query = "UPDATE competitions SET name = '$name', start_date = '$start_date', end_date = '$end_date', description = '$description' WHERE id = $id;";
			mysql_query($query);
			return true;
		}
		return false;
	}
	
	function get_competition_by_id($id) {
		$query = "SELECT * FROM competitions WHERE id = $id LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_competitor_by_id($id) {
		$query = "SELECT * FROM competitors WHERE id = $id LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_competitors_by_gender($gender) {
		$query = "SELECT * FROM competitors WHERE gender = '$gender';";
		return mysql_query($query);
	}
	
	function get_results_by_competition($competition_id, $discipline) {
		$query = "SELECT results.*, competitors.* FROM results LEFT JOIN competitors ON competitors.id = results.competitor_id WHERE competition_id = $competition_id AND discipline = '$discipline' ORDER BY placing ASC";
		return mysql_query($query);
	}
	
	function get_results_by_competitors($competitor_ids) {
		$query = "SELECT results.*, competitions.status, competitions.name, competitions.start_date, competitions.end_date, competitors.country FROM results LEFT JOIN competitions ON competitions.id = results.competition_id LEFT JOIN competitors ON competitors.id = results.competitor_id WHERE competitor_id IN (".join(",", $competitor_ids).");";
		return mysql_query($query);
	}
	
	function close_database_connection($connection) {
		mysql_close($connection);
	}
?>
