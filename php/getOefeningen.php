<?php
// Gets the data from the `site_oefeningen` table and returns it as JSON. Includes favorite status if logged in.
function getOefeninging(): array {
	$responce = [
		'code' => 500
	];
	if(
		(isset($_SERVER['HTTP_ACCEPT']) && !preg_match('/(application\/(json|\*))|\*\/\*/', $_SERVER['HTTP_ACCEPT'])) ||
		(isset($_SERVER['HTTP_ACCEPT_CHARSET']) && !preg_match('/utf-8/i', $_SERVER['HTTP_ACCEPT_CHARSET']))
	) {
		header($_SERVER["SERVER_PROTOCOL"]." 406 Not Acceptable", true, 406);
		$responce['code'] = 406;
		$responce['error'] = 'Can only provide "application/json; charset=UTF-8"';
		return $responce;
	}
	header("Content-Type: application/json");
	if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
		header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
		$responce['error'] = 'Missing internal file';
		return $responce;
	}
	require_once __DIR__ .'/credentialFunctions.php';
	// We don't mind if there isn't a session but will try to use them.
	if(session_status() == PHP_SESSION_NONE) {
		session_start([
			'use_strict_mode' => '1',
			'cookie_lifetime' => 3600,
			'cookie_secure' => '1', 'cookie_httponly' => '1',
			'cookie_samesite' => 'Strict',
		]);
	}
	$perm = null;
	$user = null;
	if(isset($_SESSION['ID']) && isset($_SESSION['loginToken'])) {
		$user = $_SESSION['ID'];
		$perm = getPerms($_SESSION['ID'], $_SESSION['loginToken']);
	} elseif(isset($_SERVER['PHP_AUTH_USER'])) {
		$user = $_SERVER['PHP_AUTH_USER'];
		$perm = getPerms($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
	}
	if(!is_int($perm)) {
		$result = DatbQuery(null,
			"SELECT
				o.*,
				IFNULL(CONCAT(
					'[',
					GROUP_CONCAT(DISTINCT '{\"src\":\"', m.link, '\",\"width\":', IFNULL(m.width, 'null'), ',\"height\":', IFNULL(m.height, 'null'), '}' ORDER BY m.ID ASC SEPARATOR ','),
					']'
				), 'null') AS images,
				GROUP_CONCAT(DISTINCT t.link ORDER BY t.ID ASC SEPARATOR '\n') AS videos,
				GROUP_CONCAT(DISTINCT w.workTitle ORDER BY w.workoutID ASC SEPARATOR '\n') AS workout
			FROM site_oefeningen o
			LEFT JOIN (
				site_link_media ml JOIN site_media m ON ml.mediaID = m.ID
			) ON ml.oefeningenID = o.ID
			LEFT JOIN (
				site_link_tube tl JOIN site_tube t ON tl.mediaID = t.ID
			) ON tl.oefeningenID = o.ID
			LEFT JOIN (
				site_workout w JOIN site_link_workout wl ON wl.workoutID = w.workoutID 
			) ON wl.oefeningID = o.ID
			GROUP BY o.ID
			ORDER BY o.ID ASC;"
		);
	} else {
		$result = DatbQuery(null,
			"SELECT
				o.*,
				IFNULL(CONCAT(
					'[',
					GROUP_CONCAT(DISTINCT '{\"src\":\"', m.link, '\",\"width\":', IFNULL(m.width, 'null'), ',\"height\":', IFNULL(m.height, 'null'), '}' ORDER BY m.ID ASC SEPARATOR ','),
					']'
				), 'null') AS images,
				GROUP_CONCAT(DISTINCT t.link ORDER BY t.ID ASC SEPARATOR '\n') AS videos,
				GROUP_CONCAT(DISTINCT w.workTitle ORDER BY w.workoutID ASC SEPARATOR '\n') AS workout,
				IF(f.ID_oefeningen IS NULL,0,1) AS favorite
			FROM site_oefeningen o
			LEFT JOIN (
				site_link_media ml JOIN site_media m ON ml.mediaID = m.ID
			) ON ml.oefeningenID = o.ID
			LEFT JOIN (
				site_link_tube tl JOIN site_tube t ON tl.mediaID = t.ID
			) ON tl.oefeningenID = o.ID
			LEFT JOIN (
				site_workout w JOIN site_link_workout wl ON wl.workoutID = w.workoutID 
			) ON wl.oefeningID = o.ID
			LEFT JOIN (SELECT ID_oefeningen FROM site_favorites WHERE ID_users=?) f ON o.ID = f.ID_oefeningen
			GROUP BY o.ID
			ORDER BY o.ID ASC;",
			'i', $user
		);
	}
	if(!($result instanceof mysqli_result)) {
		header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
		$responce['error'] = (is_string($result))?
			$result : 'Expected mysqli_result but got int instead';
		return $responce;
	}
	/** @var array<int,array<string,string|int|null>> $output */
	$output = $result->fetch_all(MYSQLI_ASSOC);
	$result->close();
	$responce['code'] = 200;
	for($i=0; $i < count($output); $i++) {
		if($output[$i]['images'] != null) {
			$decodedJson = json_decode($output[$i]['images'], true);
			if($output[$i]['images'] === false) {
				header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
				$responce['error'] = "Failed to decode JSON";
				$responce['trace'] = json_last_error_msg();
				$responce['code'] = 500;
			} else {
				$output[$i]['images'] = $decodedJson;
			}
		}
		if($output[$i]['videos'] != null)
			$output[$i]['videos'] = explode("\n", $output[$i]['videos']);
		if($output[$i]['workout'] != null)
			$output[$i]['workout'] = explode("\n", $output[$i]['workout']);
		if(isset($output[$i]['favorite']))
			$output[$i]['favorite'] = boolval($output[$i]['favorite']);
	}
	/** @var array<int,array<string,string|int|string[]|null|bool>> $output */
	$responce['output'] = $output;
	return $responce;
}
$output = json_encode(getOefeninging());
if($output == false) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"code":500,"error":"Failed to encode JSON","trace":"'. json_last_error_msg() .'"}';
	exit();
}
echo $output;