<?php
// Gets the data from the `site_oefeningen` table and returns it as JSON
header("Content-Type: application/json");
if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Missing file"}';
	exit();
}
require_once __DIR__ .'/credentialFunctions.php';
$result = DatbQuery(
	"SELECT
		o.*,
		GROUP_CONCAT(DISTINCT m.link ORDER BY m.ID ASC SEPARATOR '\n') AS images,
		GROUP_CONCAT(DISTINCT t.link ORDER BY t.ID ASC SEPARATOR '\n') AS videos
	FROM site_oefeningen o
	LEFT JOIN (
		site_link_media ml JOIN site_media m ON ml.mediaID = m.ID
	) ON ml.oefeningenID = o.ID
	LEFT JOIN (
		site_link_tube tl JOIN site_tube t ON tl.mediaID = t.ID
	) ON tl.oefeningenID = o.ID
	GROUP BY o.ID
	ORDER BY o.ID ASC;"
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
		$output[$i]['images'] = explode("\n", $output[$i]['images']);
	if($output[$i]['videos'] != null)
		$output[$i]['videos'] = explode("\n", $output[$i]['videos']);
}
/** @var array<int,array<string,string|int|array|null>> $output */
$output = json_encode($output);
if($output == false) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Failed to encode JSON"}';
	exit();
}
echo $output;