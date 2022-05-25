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
// Gets the data from the `site_oefeningen` table and returns it as JSON
header("Content-Type: application/json");
if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Missing file"}';
	exit();
}
require_once __DIR__ .'/credentialFunctions.php';
$result = DatbQuery(
	"SELECT site_oefeningen.*, site_media.link as img, site_tube.link as vid
		FROM site_oefeningen
		LEFT JOIN (
			site_link_media JOIN site_media ON site_link_media.mediaID = site_media.ID
		) ON site_link_media.oefeningenID = site_oefeningen.ID
		LEFT JOIN (
			site_link_tube JOIN site_tube ON site_link_tube.mediaID = site_tube.ID
		) ON site_link_tube.oefeningenID = site_oefeningen.ID
		ORDER BY site_oefeningen.ID ASC;"
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