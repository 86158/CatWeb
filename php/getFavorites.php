<?php
header("Content-Type: application/json");
if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Missing file"}';
	exit();
}
require_once __DIR__ .'/credentialFunctions.php';
// We don't mind if there isn't a session but will try to use them.
if(session_status() == PHP_SESSION_NONE) {
	session_start([
		'use_strict_mode' => '1',
		'cookie_lifetime' => 3600,
		'cookie_secure' => '1', 'cookie_httponly' => '1',
		'cookie_samesite' => 'Strict'
	]);
}
$perm = null;
// We could test for spam here using $_SERVER['REMOTE_ADDR'] see spamDetection.php but I've decided not to use it.
// if(!isBlocked($_SERVER['REMOTE_ADDR']) {
if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['ID'])) {
	$perm = getPerms($_SESSION['ID'], $_SESSION['loginToken']);
} elseif (isset($_SERVER['PHP_AUTH_USER'])) {
	$perm = getPerms($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
}
if(!is_int($perm)) {
	header('WWW-Authenticate: Basic realm="CatWeb", charset="UTF-8"');
	header($_SERVER["SERVER_PROTOCOL"] .' 401 Unauthorized', true, 401);
	echo ($perm)?
		'{"responce":'. $perm .'}':
		'{"responce":"Missing credentials"}';
	exit;
}
/** // If something requires additional permissions: 
*if($perm < 1) {header($_SERVER["SERVER_PROTOCOL"] .' 403 Forbidden', true, 403); echo '{"responce":"User has insuficient permissions"}'; exit;}
*/
$result = DatbQuery(
	"SELECT
			site_oefeningen.*,
			GROUP_CONCAT(site_media.link ORDER BY site_media.ID ASC SEPARATOR ' ') AS images,
			GROUP_CONCAT(site_tube.link ORDER BY site_tube.ID ASC SEPARATOR ' ') AS videos
		FROM site_oefeningen
		LEFT JOIN (
			site_link_media JOIN site_media ON site_link_media.mediaID = site_media.ID
		) ON site_link_media.oefeningenID = site_oefeningen.ID
		LEFT JOIN (
			site_link_tube JOIN site_tube ON site_link_tube.mediaID = site_tube.ID
		) ON site_link_tube.oefeningenID = site_oefeningen.ID
		INNER JOIN site_favorites ON site_oefeningen.`ID` = site_favorites.ID_oefeningen
		WHERE site_favorites.ID_users=?
		GROUP BY site_oefeningen.ID
		ORDER BY site_oefeningen.ID ASC;",
	'i', $_SERVER['PHP_AUTH_USER']
);
if(!($result instanceof mysqli_result)) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo (is_string($result))?
		'{"error":"'. $result .'"}' :
		'{"error":"Expected mysqli_result but got int instead"}';
	exit();
}
/** @var array<int,array<string,string|int|null>> $output */
$output = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
for($i=0; $i < count($output); $i++) { 
	if($output[$i]['images'] != null)
		$output[$i]['images'] = explode(" ", $output[$i]['images']);
	if($output[$i]['videos'] != null)
		$output[$i]['videos'] = explode(" ", $output[$i]['videos']);
}
/** @var array<int,array<string,string|int|array|null>> $output */
$output = json_encode($output);
if($output == false) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Failed to encode JSON"}';
	exit();
}
echo $output;