<?php
// Updates favorites
if(!preg_match('/(application\/(json|\*))|\*\/\*/', $_SERVER['HTTP_ACCEPT']) || !preg_match('/utf-8/i', $_SERVER['HTTP_ACCEPT_CHARSET'])) {
	header($_SERVER["SERVER_PROTOCOL"]." 406 Not Acceptable", true, 406);
	echo '{"error":"Can only provide \'application/json; charset=UTF-8\'"}';
	exit();
}
header("Content-Type: application/json");
if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Missing file"}';
	exit();
}
require_once __DIR__ .'/credentialFunctions.php';
$input = file_get_contents('php://input');
if($input == false) {
	header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
	echo '{"error":"file_get_contents(\'php://input\') returned false"}';
	exit();
}
$value = json_decode($input, true);
if($value == null) {
	header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
	echo '{"error":"json_decode($input, true) returned null"}';
	exit();
}
// TODO test if the JSON the one we expect.
try {
	$m_conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
} catch (mysqli_sql_exception $th) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error": "failed to get database connection", "trace": "'. $th->getTraceAsString() .'"}';
	exit();
}
/** @var array<int,array<string,bool|int>> $value */
foreach ($value as $instance) {
	if($instance['remove']) {
		DatbQuery_3($m_conn, 'DELETE FROM site_favorites WHERE ID_users = ? AND ID_oefeningen = ?', 'ii', $instance['user'], $instance['oefening']);
	} else {
		DatbQuery_3($m_conn, 'REPLACE INTO site_favorites(ID_users,ID_oefeningen) VALUE (?, ?)', 'ii', $instance['user'], $instance['oefening']);
	}
}
header($_SERVER["SERVER_PROTOCOL"]." 200 OK", true, 200);
exit();