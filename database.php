<?php	
	$connection = mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die ("Could not connect to the server.");
	mysql_select_db(DATABASE_DATABASE) or die ("Could not connect to the database.");
	mysql_set_charset('utf8');
	
	function install() {
		$query = "CREATE TABLE `users` (
		`id` INT NOT NULL AUTO_INCREMENT ,
		`name` VARCHAR(255) NOT NULL,
		`email` VARCHAR(255) NOT NULL,
		`password` TEXT NOT NULL,
		`superadmin` TINYINT(1) NOT NULL default '0',
		`lang` VARCHAR(255) NOT NULL,
		PRIMARY KEY (`id`)
		);";
		$result = mysql_query($query);
		echo $query . "<br />";
		$query = "CREATE TABLE `".DATABASE_TABLE_PREFIX."_competitions` (
		`id` INT NOT NULL AUTO_INCREMENT ,
		`start_date` date NOT NULL default '0000-00-00',
		`end_date` date NOT NULL default '0000-00-00',
		`name` VARCHAR(255) NOT NULL,
		`urlname` VARCHAR(255) NOT NULL,
		`description` TEXT NOT NULL,
		`status` bigint NOT NULL default '0',
		`distance_length` float NOT NULL default '0',
		`sprint_length` float NOT NULL default '0',
		`distance_length_female` float NOT NULL default '0',
		`sprint_length_female` float NOT NULL default '0',
		`admin_id` bigint,
		PRIMARY KEY (`id`)
		);";
		$result = mysql_query($query);
		echo $query . "<br />";
		$query = "CREATE TABLE `".DATABASE_TABLE_PREFIX."_competitors` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`first_name` VARCHAR(255) NOT NULL,
		`last_name` VARCHAR(255) NOT NULL,
		`gender` VARCHAR(255) NOT NULL,
		`country` VARCHAR(255) NOT NULL,
		PRIMARY KEY (`id`)
		);";
		$result = mysql_query($query);
		echo $query . "<br />";
		$query = "CREATE TABLE `".DATABASE_TABLE_PREFIX."_results` (
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
	
	function get_user_by_id($id) {
		$query = "SELECT * FROM users WHERE id = $id LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_user_by_email($email) {
		$query = "SELECT * FROM users WHERE LOWER(email) = LOWER('".trim($email)."') LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
  
	function get_user_by_email_and_lang($email, $lang) {
		$query = "SELECT * FROM users WHERE LOWER(email) = LOWER('".trim($email)."') AND (lang = '".$lang."' OR superadmin = 1) LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_competitions() {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitions ORDER BY start_date ASC;";
		return mysql_query($query);
	}
	
	function get_upcoming_competitions() {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitions WHERE start_date > NOW() ORDER BY start_date ASC;";
		return mysql_query($query);
	}
	
	function get_previous_competitions() {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitions WHERE end_date < NOW() ORDER BY start_date ASC;";
		return mysql_query($query);
	}
	
	function update_competition($id, $name, $urlname, $start_date, $end_date, $sprint_length, $distance_length, $sprint_length_female, $distance_length_female, $status, $description) {
		if (isset($id) && isset($name) && isset($urlname) && isset($start_date) && isset($end_date) && isset($status) && $id != "" && $name != "" && $urlname != "" && $start_date != "" && $end_date != "" && $status != "") {
			$sprint_length = ((isset($sprint_length) && $sprint_length != "" && is_numeric($sprint_length)) ? $sprint_length : 0);
			$distance_length = ((isset($distance_length) && $distance_length != "" && is_numeric($distance_length)) ? $distance_length : 0);
			$sprint_length_female = ((isset($sprint_length_female) && $sprint_length_female != "" && is_numeric($sprint_length_female)) ? $sprint_length_female : 0);
			$distance_length_female = ((isset($distance_length_female) && $distance_length_female != "" && is_numeric($distance_length_female)) ? $distance_length_female : 0);
			$query = "UPDATE ".DATABASE_TABLE_PREFIX."_competitions SET name = '$name', urlname = '$urlname', start_date = '$start_date', end_date = '$end_date', sprint_length = $sprint_length, distance_length = $distance_length, sprint_length_female = $sprint_length_female, distance_length_female = $distance_length_female, status = $status, description = '$description' WHERE id = $id;";
			mysql_query($query);
			return true;
		}
		return false;
	}
	
	function create_competition($name, $urlname, $start_date, $end_date, $sprint_length, $distance_length, $sprint_length_female, $distance_length_female, $status, $description) {
		if (isset($name) && isset($urlname) && isset($start_date) && isset($end_date) && isset($status) && $name != "" && $urlname != "" && $start_date != "" && $end_date != "" && $status != "") {
			$sprint_length = ((isset($sprint_length) && $sprint_length != "" && is_numeric($sprint_length)) ? $sprint_length : 0);
			$distance_length = ((isset($distance_length) && $distance_length != "" && is_numeric($distance_length)) ? $distance_length : 0);
			$sprint_length_female = ((isset($sprint_length_female) && $sprint_length_female != "" && is_numeric($sprint_length_female)) ? $sprint_length_female : 0);
			$distance_length_female = ((isset($distance_length_female) && $distance_length_female != "" && is_numeric($distance_length_female)) ? $distance_length_female : 0);
			$query = "INSERT INTO ".DATABASE_TABLE_PREFIX."_competitions (name, urlname, start_date, end_date, sprint_length, distance_length, sprint_length_female, distance_length_female, status, description) VALUES ('$name', '$urlname', '$start_date', '$end_date', $sprint_length, $distance_length, $sprint_length_female, $distance_length_female, $status, '$description');";
			mysql_query($query);
			return true;
		}
		return false;
	}
	
	function get_competition_by_id($id) {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitions WHERE id = $id LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_competition_by_id_or_urlname($id) {
		if (is_numeric($id)) {
			$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitions WHERE id = $id LIMIT 1;";
		} else {
			$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitions WHERE urlname = '$id' LIMIT 1;";
		}
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_competitor_by_id($id) {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitors WHERE id = $id LIMIT 1;";
		$result = mysql_query($query);
		return mysql_fetch_object($result);
	}
	
	function get_competitors() {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitors;";
		return mysql_query($query);
	}
	
	function get_competitors_by_gender($gender) {
		$query = "SELECT * FROM ".DATABASE_TABLE_PREFIX."_competitors WHERE gender = '$gender';";
		return mysql_query($query);
	}
	
	function update_competitor($id, $first_name, $last_name, $gender, $country) {
		if (isset($id) && isset($first_name) && isset($last_name) && isset($gender) && isset($country) && $id != "" && $first_name != "" && $last_name != "" && $gender != "" && $country != "") {
			$query = "UPDATE ".DATABASE_TABLE_PREFIX."_competitors SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', country = '$country' WHERE id = $id;";
			mysql_query($query);
			return true;
		}
		return false;
	}
	
	function create_competitors($competitors) {
		$successes = array();
		$errors = array();
		foreach ($competitors as $competitor) {
			if ($competitor_id = create_competitor($competitor["first_name"], $competitor["last_name"], $competitor["gender"], $competitor["country"])) {
				$competitor["competitor_id"] = $competitor_id;
				array_push($successes, $competitor);
			} else {
				array_push($errors, $competitor);
			}
		}
		return array("successes" => $successes, "errors" => $errors);
	}
	
	function create_competitor($first_name, $last_name, $gender, $country) {
		if (isset($first_name) && isset($last_name) && isset($gender) && isset($country) && $first_name != "" && $last_name != "" && $gender != "" && $country != "") {
			$query = "INSERT INTO ".DATABASE_TABLE_PREFIX."_competitors (first_name, last_name, gender, country) VALUES ('$first_name', '$last_name', '$gender', '$country');";
			mysql_query($query);
			return mysql_insert_id();
		}
		return false;
	}
	
	function create_result($competition_id, $competitor_id, $discipline, $class, $placing, $time) {
		if (isset($competition_id) && isset($competitor_id) && isset($discipline) && isset($placing) && $competition_id != "" && $competitor_id != "" && $discipline != "" && $placing != "") {
			$query = "INSERT INTO ".DATABASE_TABLE_PREFIX."_results (competition_id, competitor_id, discipline, class, placing, time) VALUES ($competition_id, $competitor_id, '$discipline', '$class', $placing, ".time_for_database($time).");";
			mysql_query($query);
			return mysql_insert_id();
		}
		return false;
	}
	
	function update_result($id, $competitor_id, $class, $time) {
		if (isset($id) && isset($competitor_id) && $id != "" && $competitor_id != "") {
			$query = "UPDATE ".DATABASE_TABLE_PREFIX."_results SET competitor_id = $competitor_id, class = '$class', time = ".time_for_database($time)." WHERE id = $id;";
			mysql_query($query);
			return $id;
		}
		return false;
	}
	
	function get_all_results_by_competition($competition_id) {
		$query = "SELECT ".DATABASE_TABLE_PREFIX."_results.*, ".DATABASE_TABLE_PREFIX."_competitors.first_name, ".DATABASE_TABLE_PREFIX."_competitors.last_name, ".DATABASE_TABLE_PREFIX."_competitors.gender, ".DATABASE_TABLE_PREFIX."_competitors.country FROM ".DATABASE_TABLE_PREFIX."_results LEFT JOIN ".DATABASE_TABLE_PREFIX."_competitors ON ".DATABASE_TABLE_PREFIX."_competitors.id = ".DATABASE_TABLE_PREFIX."_results.competitor_id WHERE ".DATABASE_TABLE_PREFIX."_results.competition_id = $competition_id ORDER BY placing ASC";
		return mysql_query($query);
	}
	
	function get_results_by_competition($competition_id, $gender, $discipline) {
		$query = "SELECT ".DATABASE_TABLE_PREFIX."_results.*, ".DATABASE_TABLE_PREFIX."_competitors.first_name, ".DATABASE_TABLE_PREFIX."_competitors.last_name, ".DATABASE_TABLE_PREFIX."_competitors.gender, ".DATABASE_TABLE_PREFIX."_competitors.country FROM ".DATABASE_TABLE_PREFIX."_results LEFT JOIN ".DATABASE_TABLE_PREFIX."_competitors ON ".DATABASE_TABLE_PREFIX."_competitors.id = ".DATABASE_TABLE_PREFIX."_results.competitor_id WHERE ".DATABASE_TABLE_PREFIX."_results.competition_id = $competition_id AND ".DATABASE_TABLE_PREFIX."_results.discipline = '$discipline' AND ".DATABASE_TABLE_PREFIX."_competitors.gender = '$gender' ORDER BY placing ASC";
		return mysql_query($query);
	}
	
	function get_results_by_competitors($competitor_ids) {
		$query = "SELECT ".DATABASE_TABLE_PREFIX."_results.*, ".DATABASE_TABLE_PREFIX."_competitions.status, ".DATABASE_TABLE_PREFIX."_competitions.name, ".DATABASE_TABLE_PREFIX."_competitions.sprint_length, ".DATABASE_TABLE_PREFIX."_competitions.distance_length, ".DATABASE_TABLE_PREFIX."_competitions.sprint_length_female, ".DATABASE_TABLE_PREFIX."_competitions.distance_length_female, ".DATABASE_TABLE_PREFIX."_competitions.start_date, ".DATABASE_TABLE_PREFIX."_competitions.end_date, ".DATABASE_TABLE_PREFIX."_competitors.country FROM ".DATABASE_TABLE_PREFIX."_results LEFT JOIN ".DATABASE_TABLE_PREFIX."_competitions ON ".DATABASE_TABLE_PREFIX."_competitions.id = ".DATABASE_TABLE_PREFIX."_results.competition_id LEFT JOIN ".DATABASE_TABLE_PREFIX."_competitors ON ".DATABASE_TABLE_PREFIX."_competitors.id = ".DATABASE_TABLE_PREFIX."_results.competitor_id WHERE competitor_id IN (".join(",", $competitor_ids).");";
		return mysql_query($query);
	}
	
	function delete_results($result_ids) {
		$query = "DELETE FROM ".DATABASE_TABLE_PREFIX."_results WHERE id IN (".join(",", $result_ids).");";
		mysql_query($query);
	}
	
	function update_results($competition_id, $results) {
		$created_results = array();
		$errors = array();
		
		$existing_result_ids = result_ids_by_competition($competition_id);
		
		foreach (array("female", "male") as $gender) if (isset($results[$gender])) foreach (array("distance", "sprint") as $discipline) if (isset($results[$gender][$discipline])) foreach ($results[$gender][$discipline] as $i => $result) {
			$placing = $i+1;
			$competitor_id = $result["competitor_id"];
			$class = (isset($result["class"])) ? $result["class"] : "";
			$time = $result["time"];
			if ($created_id = create_result($competition_id, $competitor_id, $discipline, $class, $placing, $time)) {
				array_push($created_results, $created_id);
			} else {
				array_push($errors, array("competitor_id" => $competitor_id, "discipline" => $discipline, "gender" => $gender, "class" => $class, "time" => $time, "placing" => $placing));
			}
		}
		
		if (sizeof($created_results) > 0) {
			if (sizeof($errors) > 0) {
				delete_results($created_results);
			} else {
				delete_results($existing_result_ids);
			}
		}
		
		return array("created_results" => $created_results, "errors" => $errors);
	}
	
	function close_database_connection($connection) {
		mysql_close($connection);
	}
?>
