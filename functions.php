<?php
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
		return isset($_SESSION["logged_in"]);
	}

	function login($username, $password) {
		if ($username == ADMIN_USERNAME && sha1($password) == ADMIN_PASSWORD) {
			$_SESSION["logged_in"] = true;
			return true;		
		} else {
			return false;
		}
	}

	function logout() {
		if (isset($_SESSION["logged_in"])) { unset($_SESSION["logged_in"]); }
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
			if ($i >= 2) break;
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
		foreach ($competitors as $competitor) if ($competitor->country == "SWE") {
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
			return "Kvinna'";
		}
	}
	
	
	function readable_time($time) {
		return ($time > 0 ? gmdate("H:i:s", $time) : "–");
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
		foreach ($results as $r) if ($r->competition_id == $result->competition_id && $r->competitor_id != $result->competitor_id && $r->discipline == $result->discipline && $r->placing < $result->placing && ($r->country != "SWE" || ($r->class == "14" && $result->class == "126"))) {
			$placing--;
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