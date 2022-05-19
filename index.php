<?php
// The session_start() function must be the very first thing in your document. Before any HTML tags.
// If we need sessions to exist:
/*if(session_status() == PHP_SESSION_DISABLED) {
	header($_SERVER["SERVER_PROTOCOL"]." 409 Conflict", true, 409);
	header("Content-Type: application/json");
	echo '{"error":"This website requires sessions to be enabled"}';
}
if(!session_start(
	[
		'use_strict_mode' => '1',
		'cookie_lifetime' => 3600,
		'cookie_secure' => '1', 'cookie_httponly' => '1',
		'cookie_samesite' => 'Strict'
	]
)) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	header("Content-Type: application/json");
	echo '{"error":"Failed to create/maintain a session."}';
	exit();
}*/
// We don't mind if there isn't a session but will try to use them.
if(session_status() == PHP_SESSION_NONE) {
	session_start([
		'use_strict_mode' => '1',
		'cookie_lifetime' => 3600,
		'cookie_secure' => '1', 'cookie_httponly' => '1',
		'cookie_samesite' => 'Strict'
	]);
}
// Check if the files we need exist
if(!(
	file_exists(__DIR__ .'/php/credentialFunctions.php') &&
	file_exists(__DIR__ .'/php/globalFunctions.php') &&
	file_exists(__DIR__ .'/pages/head.html')
)) {
	header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
	echo '{"error":"Missing file(s)"}';
	exit();
}
// defining global vars
// Getting functions
require_once __DIR__ .'/php/globalFunctions.php';
// Getting the head.
require __DIR__ .'/pages/head.html';
// Geting the page.
require __DIR__ . returnPage();
// Getting footer.
// include __DIR__ .'/pages/footer.html';