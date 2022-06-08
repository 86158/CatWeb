<?php
if(
		(isset($_SERVER['HTTP_ACCEPT']) && !preg_match('/(application\/(json|\*))|\*\/\*/', $_SERVER['HTTP_ACCEPT'])) ||
		(isset($_SERVER['HTTP_ACCEPT_CHARSET']) && !preg_match('/utf-8/i', $_SERVER['HTTP_ACCEPT_CHARSET']))
) {
	header($_SERVER['SERVER_PROTOCOL'] .' 406 Not Acceptable', true, 406);
	exit();
}
$input = file_get_contents('php://input');
if($input === false) {
	header($_SERVER['SERVER_PROTOCOL'] .' 400 Bad Request', true, 400);
	exit();
}
if($input == '') {
	header($_SERVER['SERVER_PROTOCOL'] .' 204 No Content', true, 204);
	exit();
}
$result = file_put_contents(__DIR__ .'/report-'. time() .'.json', $input, LOCK_EX);
if($result === false) {
	header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error', true, 500);
	exit();
}
header($_SERVER['SERVER_PROTOCOL'] .' 201 Created', true, 201);