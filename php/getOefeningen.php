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
		GROUP BY site_oefeningen.ID
		ORDER BY site_oefeningen.ID ASC;"
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