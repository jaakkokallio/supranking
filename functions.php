<?php
	if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
    	header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
    	exit;
	}

	session_start();

	date_default_timezone_set("Europe/Stockholm");
	setlocale(LC_ALL, 'sv_SE');
		
	function environment() {
		if ($_SERVER["SERVER_NAME"] == "supranking.dev") { return "dev"; }
		return "prod";
	}

	function page() {
		return str_replace(".php", "", basename($_SERVER["PHP_SELF"]));
	}

	include("config.".environment().".php");
	include("database.php");


	function is_logged_in() {
		return isset($_SESSION["user_id"]);
	}
	
	function current_user() {
		if (is_logged_in()) {
			return get_user_by_id($_SESSION["user_id"]);
		}
		return false;
	}
	
	function is_superadmin() {
		if (is_logged_in()) {
			return current_user()->superadmin == 1;
		}
		return false;
	}

	function login($email, $password) {
		$user = get_user_by_email($email);
		if ($user && $user->password == sha1($password)) {
			$_SESSION["user_id"] = true;
			return true;		
		} else {
			return false;
		}
	}

	function logout() {
		if (isset($_SESSION["user_id"])) { unset($_SESSION["user_id"]); }
	}
	
	function competitors($gender) {
		$competitors_by_gender = array();
		$competitors = get_competitors_by_gender($gender);
		if ($competitors && mysql_num_rows($competitors) > 0) {
			while ($competitor = mysql_fetch_object($competitors)) { 
				array_push($competitors_by_gender, $competitor); 
			}
		}
		return $competitors_by_gender;
	}
	
	function competitor_names($gender) {
		$competitor_names = array();
		$competitors = get_competitors_by_gender($gender);
		if ($competitors && mysql_num_rows($competitors) > 0) {
			while ($competitor = mysql_fetch_object($competitors)) { 
				$name = $competitor->first_name." ".$competitor->last_name;
				if ($competitor->country != "SWE") { $name .= " (".$competitor->country.")"; }
				array_push($competitor_names, array("competitor_id" => $competitor->id, "competitor" => $name)); 
			}
		}
		return $competitor_names;
	}
	
	function results_for_spreadsheet($competition_id, $gender, $discipline) {				
		$results_for_spreadsheet = array();
		$results = get_results_by_competition($competition_id, $gender, $discipline);
		if ($results && mysql_num_rows($results) > 0) {
			while ($result = mysql_fetch_object($results)) {
				$r = new StdClass();
				$r->competitor_id = $result->competitor_id;
				$r->competitor = $result->first_name." ".$result->last_name;
				if ($result->country != "SWE") { $r->competitor .= " (".$result->country.")"; }
				if ($result->class) { $r->class = $result->class; }
				$r->time = ($result->time > 0) ? gmdate("H:i:s", $result->time) : "";
				
				array_push($results_for_spreadsheet, $r);
			}
		}
		return json_encode($results_for_spreadsheet);
	}
	
	function result_ids_by_competition($competition_id) {
		$result_ids = array();
		$results = get_all_results_by_competition($competition_id);
		if ($results && mysql_num_rows($results) > 0) {
			while ($result = mysql_fetch_object($results)) {
				array_push($result_ids, $result->id); 
			}
		}
		return $result_ids;
	}
	
	function results_by_competitors($competitors) {		
		$results_by_competitors = array();
		$results = get_results_by_competitors(array_map(function($competitor) { return $competitor->id; }, $competitors));
		if ($results && mysql_num_rows($results) > 0) {
			while ($result = mysql_fetch_object($results)) {
				$result->placing = intval($result->placing);
				$result->time = intval($result->time);
				$result->status = intval($result->status);
				array_push($results_by_competitors, $result); 
			}
		}
		return $results_by_competitors;
	}
	
	function results_by_competitor($competitor) {
		$results = new StdClass();
		$results->distance_results = array();
		$results->sprint_results = array();
		
		$results_by_competitor = results_by_competitors(array($competitor));
		$results_by_competitors = results_by_competitors(competitors($competitor->gender));
		
		foreach ($results_by_competitor as $r) {
			$r->adjusted_placing = adjusted_placing($r, $results_by_competitors);
			$r->points = competitor_points($results_by_competitors, $r, $r->adjusted_placing);
			$r->points_added_to_sum = false;
			if ($r->discipline == "distance") {
				array_push($results->distance_results, $r);
			} else if ($r->discipline == "sprint") {
				array_push($results->sprint_results, $r);
			}
		}
		
		usort($results->distance_results, function($a, $b) { return $a->points < $b->points; });
		foreach ($results->distance_results as $i => $r) {
			$r->points_added_to_sum = true;
			if ($i >= COMPETITIONS_ADDED_TO_SUM-1) break;
		}
		usort($results->distance_results, function($a, $b) { return $a->start_date > $b->start_date; });

		usort($results->sprint_results, function($a, $b) { return $a->points < $b->points; });
		foreach ($results->sprint_results as $i => $r) {
			$r->points_added_to_sum = true;
			if ($i >= COMPETITIONS_ADDED_TO_SUM-1) break;
		}
		usort($results->sprint_results, function($a, $b) { return $a->start_date > $b->start_date; });

		foreach (ranking($competitor->gender) as $r) if ($r->competitor_id == $competitor->id) {
			$results->points = $r->points;
			$results->placing = $r->placing;
		}
		
		foreach (ranking($competitor->gender, "distance") as $r) if ($r->competitor_id == $competitor->id) {
			$results->distance_points = $r->points;
			$results->distance_placing = $r->placing;
		}
		
		foreach (ranking($competitor->gender, "sprint") as $r) if ($r->competitor_id == $competitor->id) {
			$results->sprint_points = $r->points;
			$results->sprint_placing = $r->placing;
		}

		return $results;
	}
	
	function ranking($gender, $discipline = null) {
		$ranking = array();
		$competitors = competitors($gender);
		$results = results_by_competitors($competitors);
		foreach ($competitors as $competitor) {
			$r = new StdClass();
			$r->distance_points = competitor_points_sum($results, $competitor, "distance");
			$r->sprint_points = competitor_points_sum($results, $competitor, "sprint");	
			$r->points = ($discipline == "distance" ? $r->distance_points : ($discipline == "sprint" ? $r->sprint_points : ($r->distance_points+$r->sprint_points)));
			$r->competitor_id = $competitor->id;
			$r->first_name = $competitor->first_name;
			$r->last_name = $competitor->last_name;
			$r->class = competitor_classes($results, $competitor);
			$r->distance_competitions = number_of_competitions($results, $competitor, "distance");
			$r->sprint_competitions = number_of_competitions($results, $competitor, "sprint");
			if ($r->distance_competitions > 0 || $r->sprint_competitions > 0) array_push($ranking, $r);
		}
		usort($ranking, function($a, $b) { return $a->points < $b->points; });
		$placing = 0;
		$ranks_with_equal_points = 0;
		$previous_rank = null;
		foreach ($ranking as $r) {
			if ($previous_rank && $previous_rank->points == $r->points) {
				$ranks_with_equal_points++; 
			} else if ($ranks_with_equal_points > 0) {
				$placing += $ranks_with_equal_points+1;
				$ranks_with_equal_points = 0;
			} else {
				$placing++;
			}
			$r->placing = $placing;
			$previous_rank = $r;
		}
		return $ranking;
	}

	function competition_length($competition, $gender, $discipline) {
		if ($discipline == "sprint") {
			if ($competition->sprint_length && $competition->sprint_length != 0) {
				if ($gender == "female" && $competition->sprint_length_female && $competition->sprint_length_female != 0) {
					return $competition->sprint_length_female;
				} else {
					return $competition->sprint_length;
				}
			} else {
				return 0;
			}
		} else if ($discipline == "distance") {
			if ($competition->distance_length && $competition->distance_length != 0) {
				if ($gender == "female" && $competition->distance_length_female && $competition->distance_length_female != 0) {
					return $competition->distance_length_female;
				} else {
					return $competition->distance_length;
				}
			} else {
				return 0;
			}	
		} else {
			return 0;
		}
	}
	
	function readable_competition_length($competition, $gender, $discipline) {
		$length = competition_length($competition, $gender, $discipline);
		if ($length != 0) {
			if ($discipline == "sprint") {
				return ($length*1000)." m";
			} else if ($discipline == "distance") {
				return $length." km";
			}
		} else {
			return "";
		}
	}
	
	function readable_discipline($discipline) {
		if ($discipline == "distance") {
		    return "Distans";
		} elseif ($discipline == "sprint") {
			return "Sprint";
		}
	}
	
	function readable_class($class) {
		if ($class == "126") {
		    return "12'6\"";
		} elseif ($class == "14") {
			return "14'";
		}
	}
	
	function readable_gender($gender) {
		if ($gender == "male") {
		    return "Man";
		} elseif ($gender == "female") {
			return "Kvinna";
		}
	}
	
	
	function readable_time($time) {
		return ($time > 0 ? (($time >= 3600) ? gmdate("H:i:s", $time) : gmdate("i:s", $time)) : "–");
	}
	
	function readable_diff($winner_time, $time) {
		if ($time > 0 && ($time-$winner_time) > 0) {
			if (($time-$winner_time) >= 3600) {
				return "+".gmdate("H:i:s", ($time-$winner_time));
			}
			return "+".gmdate("i:s", ($time-$winner_time));
		}
		return "–";
	}
	
	function readable_velocity($time, $length) {
		return ($time > 0 && $length && $length > 0 ? number_format(round($length/($time/60/60), 2), 2)." km/h" : "–");
	}
	
	function class_for_database($class) {
		if ($class == "12'6\"") {
		    return "126";
		} elseif ($class == "14'") {
			return "14";
		}
		return "";
	}
	
	function time_for_database($time) {
		if ($time != "") {
			return strtotime("1970-01-01 ".$time."GMT");
		}
		return 0;
	}
	
	function readable_date_range($start_date, $end_date) {
		if ((date("mYd", $start_date) == date("mYd", $end_date))) {
			return strtolower(strftime("%e %b", $end_date));
		} else if (date("mY", $start_date) == date("mY", $end_date)) {
			return strtolower(strftime("%e", $start_date) . " - " . strftime("%e %b", $end_date));
		} else {
			return strtolower(strftime("%e %b", $start_date) . " - " . strftime("%e %b", $end_date));
		}
	}
	
	function competitor_classes($results, $competitor) {
		$classes = array();
		foreach ($results as $result) if ($result->competitor_id == $competitor->id && $result->discipline == "distance" && !in_array($result->class, $classes)) array_push($classes, $result->class); 
		return join(", ", array_map("readable_class", $classes));
	}
	
	function calculate_points($status, $placing) {
		return $status*placing_factor($placing)*1000;
	}
	
	function competitor_points_sum($results, $competitor, $discipline) {
		$points = array();
		foreach ($results as $result) if ($result->competitor_id == $competitor->id && $result->discipline == $discipline) {
			$placing = adjusted_placing($result, $results);
			array_push($points, calculate_points($result->status, $placing));
		}
		rsort($points);
		return array_sum(array_slice($points, 0, COMPETITIONS_ADDED_TO_SUM));
	}
	
	function competitor_points($results, $result, $adjusted_placing) {
		return calculate_points($result->status, $adjusted_placing);
	}
	
	function adjusted_placing($result, $results) {
		$placing = $result->placing;
		if (HAS_CLASSES) {
			foreach ($results as $r) if ($r->competition_id == $result->competition_id && $r->competitor_id != $result->competitor_id && $r->discipline == $result->discipline && $r->placing < $result->placing && ($r->class == "14" && $result->class == "126")) {
				$placing--;
			}
		}
		return $placing;
	}
	
	function placing_factor($placing) {
		if ($placing <= 10) {
			return 1-($placing-1)*0.1;
		} elseif ($placing <= 18) {
			return 0.1-($placing-10)*0.01;
		} else {
			return 0.02;
		}
	}
	
	function number_of_competitions($results, $competitor, $discipline) {
		$number_of_competitions = 0;
		foreach ($results as $result) if ($result->competitor_id == $competitor->id && $result->discipline == $discipline) $number_of_competitions++;
		return $number_of_competitions;
	}

	function countries() {
		return unserialize(COUNTRIES);
	}

?>