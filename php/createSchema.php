<?php
// Updates favorites based on provided body
function setFavorites(): array {
	$responce = [
		'code' => 500
	];
	if(
		(isset($_SERVER['HTTP_ACCEPT']) && !preg_match('/(application\/(json|\*))|\*\/\*/', $_SERVER['HTTP_ACCEPT'])) ||
		(isset($_SERVER['HTTP_ACCEPT_CHARSET']) && !preg_match('/utf-8/i', $_SERVER['HTTP_ACCEPT_CHARSET']))
	) {
		header($_SERVER['SERVER_PROTOCOL'] .' 406 Not Acceptable', true, 406);
		$responce['code'] = 406;
		$responce['error'] = 'Can only provide \'application/json; charset=UTF-8\'';
		return $responce;
	}
	header('Content-Type: application/json');
	if(!file_exists(__DIR__ .'/credentialFunctions.php')) {
		header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
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
			'cookie_samesite' => 'Strict'
		]);
	}
	$perm = null;
	$user = null;
	if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['ID'])) {
		$user = $_SESSION['ID'];
		$perm = getPerms($_SESSION['ID'], $_SESSION['loginToken']);
	} elseif(isset($_SERVER['PHP_AUTH_USER'])) {
		$user = $_SERVER['PHP_AUTH_USER'];
		$perm = getPerms($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
	}
	if(!is_int($perm)) {
		header('WWW-Authenticate: Basic realm="CatWeb", charset="UTF-8"');
		header($_SERVER['SERVER_PROTOCOL'] .' 401 Unauthorized', true, 401);
		$responce['code'] = 401;
		$responce['error'] = 'Missing credentials';
		if($perm)
			$responce['trace'] = $perm;
		return $responce;
	}
	$input = file_get_contents('php://input');
	if($input === false) {
		header($_SERVER['SERVER_PROTOCOL'] .' 400 Bad Request', true, 400);
		$responce['code'] = 400;
		$responce['error'] = 'file_get_contents(\'php://input\') returned false';
		return $responce;
	}
	if($input == '') {
		header($_SERVER['SERVER_PROTOCOL'] .' 204 No Content', true, 204);
		$responce['code'] = 204;
		$responce['error'] = 'file_get_contents(\'php://input\') returned a empty string';
		return $responce;
	}
	$value = json_decode($input, true);
	if($value == null) {
		header($_SERVER['SERVER_PROTOCOL'] .' 400 Bad Request', true, 400);
		$responce['code'] = 400;
		$responce['error'] = 'json_decode($input, true) returned null';
		return $responce;
	}
	try {
		$m_conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
	} catch (mysqli_sql_exception $th) {
		header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
		$responce['error'] = 'failed to create database connection';
		$responce['trace'] = $th->getTraceAsString();
		return $responce;
	}
	// Create a new schema and then get the ID.
	$query = DatbQuery($m_conn, 'INSERT INTO `site_schema` (`ID`, `ID_users`) VALUES (NULL, ?)', 'i', $user);
	if($query != 1) {
		header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
		$responce['error'] = 'Failed to create new schema';
		$responce['trace'] = $m_conn->error;
		$m_conn->close();
		return $responce;
	}
	if($query instanceof mysqli_result)
		$query->close();
	$query = DatbQuery($m_conn, 'SELECT LAST_INSERT_ID()');
	if(!($query instanceof mysqli_result)) {
		header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
		$responce['error'] = 'Failed get LAST_INSERT_ID from new schema';
		$responce['trace'] = $m_conn->error;
		$m_conn->close();
		return $responce;
	}
	$last_id = $query->fetch_row();
	$query->close();
	if(!is_array($last_id) || !is_int($last_id[0])) {
		header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
		$responce['error'] = 'Failed get LAST_INSERT_ID from new schema';
		$responce['trace'] = $m_conn->error;
		$m_conn->close();
		return $responce;
	}
	$last_id = $last_id[0];
	/** @var int $last_id */
	$error = null;
	/** @var int[] $value */
	foreach($value as $instance) {
		if(!is_int($instance)) {
			header($_SERVER['SERVER_PROTOCOL'] .' 400 Bad Request', true, 400);
			$responce['code'] = 400;
			$responce['error'] = 'JSON was not of the expected schema';
			DatbQuery($m_conn, 'DELETE FROM site_schema WHERE `site_schema`.`ID` = ?', 'i', $last_id);
			$m_conn->close();
			return $responce;
		}
		$error = DatbQuery($m_conn, 'INSERT INTO `site_schemacontent` (`ID`, `ID_schema`, `ID_oefeningen`) VALUES (null, ?, ?)', 'ii', $last_id, $instance);
		if(is_string($error)) {
			header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
			$responce['error'] = 'Failed to add item to schema';
			$responce['trace'] = $error;
			DatbQuery($m_conn, 'DELETE FROM site_schema WHERE `site_schema`.`ID` = ?', 'i', $last_id);
			$m_conn->close();
			return $responce;
		}
	}
	$m_conn->close();
	header($_SERVER['SERVER_PROTOCOL'] .' 200 OK', true, 200);
	$responce['code'] = 200;
	return $responce;
}
$output = json_encode(setFavorites());
if($output == false) {
	header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
	echo '{"code":500,"error":"Failed to encode JSON","trace":"'. json_last_error_msg() .'"}';
	exit();
}
echo $output;