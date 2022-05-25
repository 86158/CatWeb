<?php
/**
 * Returns all the values from the array and indexes the array numerically.
 * In contrast to array_values() this function does this transformation inplace.
 * This is more memory efficient than `$array = array_values($array);`
 * @param array &$array The array to reindex.
 * @see https://www.php.net/manual/en/function.array-values.php#36837
 */
function array_reindex(array &$array): void {
	$i = 0;
	foreach($array as $key => $value) {
		if($i != $key) {
			$array[$i] = $value;
			unset($array[$key]);
		}
		$i++;
	}
}
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
	"SELECT o.*, site_media.link AS img, site_tube.link AS vid
		FROM site_oefeningen o 
		LEFT JOIN (
			site_link_media JOIN site_media ON site_link_media.mediaID = site_media.ID
		) ON site_link_media.oefeningenID = o.ID
		LEFT JOIN (
			site_link_tube JOIN site_tube ON site_link_tube.mediaID = site_tube.ID
		) ON site_link_tube.oefeningenID = o.ID
		INNER JOIN site_favorites f ON o.`ID` = f.`ID_oefeningen`
		WHERE f.ID_users=?
		ORDER BY o.ID ASC",
	'i', $_SERVER['PHP_AUTH_USER']
);
if(!($result instanceof mysqli_result)) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo (is_string($result))?
		'{"error":"'. $result .'"}' :
		'{"error":"Expected mysqli_result but got int instead"}';
	exit();
}
/** @var array<int,array<string,string|int|array>> $output */
$output = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
$prevIndex = 0;
$count = count($output);
$output[0]['img'] = [$output[0]['img']];
$output[0]['vid'] = [$output[0]['vid']];
for($i=1; $i < $count; $i++) {
	$prev = $output[$prevIndex];
	$curr = $output[$i];
	$curr['img'] = [$curr['img']];
	$curr['vid'] = [$curr['vid']];
	$output[$i] = $curr;
	if($prev['ID'] != $curr['ID']) {
		$prevIndex = $i;
		continue;
	}
	array_push($prev['img'], $curr['img'][0]);
	$prev['img'] = array_unique($prev['img']);
	array_push($prev['vid'], $curr['vid'][0]);
	$prev['vid'] = array_unique($prev['vid']);
	$output[$prevIndex] = $prev;
	unset($output[$i]);
}
array_reindex($output);
$output = json_encode($output);
if($output == false) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Failed to encode JSON"}';
	exit();
}
echo $output;