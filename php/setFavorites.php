<?php
// Updates favorites
/*
interface responce { 
	code: number;
	error?: string;
	trace?: string;
}
*/
if(
	(isset($_SERVER['HTTP_ACCEPT']) && !preg_match('/(application\/(json|\*))|\*\/\*/', $_SERVER['HTTP_ACCEPT'])) ||
	(isset($_SERVER['HTTP_ACCEPT_CHARSET']) && !preg_match('/utf-8/i', $_SERVER['HTTP_ACCEPT_CHARSET']))
) {
	header($_SERVER["SERVER_PROTOCOL"]." 406 Not Acceptable", true, 406);
	echo '{"code":406,"error":"Can only provide \'application/json; charset=UTF-8\'"}';
	exit();
}
header("Content-Type: application/json");
if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"code":500,"error":"Missing file"}';
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
$user = null;
// We could test for spam here using $_SERVER['REMOTE_ADDR'] see spamDetection.php but I've decided not to use it.
// if(!isBlocked($_SERVER['REMOTE_ADDR']) {
if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['ID'])) {
	$user = $_SESSION['ID'];
	$perm = getPerms($_SESSION['ID'], $_SESSION['loginToken']);
} elseif(isset($_SERVER['PHP_AUTH_USER'])) {
	$user = $_SERVER['PHP_AUTH_USER'];
	$perm = getPerms($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
}
if(!is_int($perm)) {
	header('WWW-Authenticate: Basic realm="CatWeb", charset="UTF-8"');
	header($_SERVER["SERVER_PROTOCOL"] .' 401 Unauthorized', true, 401);
	echo ($perm)?
		'{"code":401,"error":"Missing credentials","trace":'. $perm .'}':
		'{"code":401,"error":"Missing credentials"}';
	exit;
}
$input = file_get_contents('php://input');
if($input == false) {
	header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
	echo '{"code":400,"error":"file_get_contents(\'php://input\') returned false"}';
	exit();
}
$value = json_decode($input, true);
if($value == null) {
	header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
	echo '{"code":400,"error":"json_decode($input, true) returned null"}';
	exit();
}
try {
	$m_conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
} catch (mysqli_sql_exception $th) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"code":500,"error":"failed to get database connection","trace":"'. $th->getTraceAsString() .'"}';
	exit();
}
$error = null;
/** @var array<int,array<string,bool|int>> $value */
foreach($value as $instance) {
	if($instance['remove']) {
		$error = DatbQuery_3($m_conn, 'DELETE FROM site_favorites WHERE ID_users = ? AND ID_oefeningen = ?', 'ii', $user, $instance['oefening']);
	} else {
		$error = DatbQuery_3($m_conn, 'REPLACE INTO site_favorites(ID_users,ID_oefeningen) VALUE (?, ?)', 'ii', $user, $instance['oefening']);
	}
	if(is_string($error)) {
		$m_conn->close();
		header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
		echo '{"code":400,"error":"JSON was not of the expected schema","trace": "'. var_export($error, true) .'"}';
		exit();
	}
}
$m_conn->close();
header($_SERVER["SERVER_PROTOCOL"]." 200 OK", true, 200);
echo '{"code":200}';
exit();