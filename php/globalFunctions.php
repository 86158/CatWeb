<?php
// Ensure the functions we need are imported.
require_once __DIR__.'/credentialFunctions.php';
/** Get the page.
 * @return string The url of the page to load.
*/
function returnPage(): string {
	// perms is used to track the permissionlevel of the user.
	$m_perms = -1;
	// Logout
	if(isset($_POST['logout'])) {
		session_unset();
	// Create new user.
	} elseif(isset($_POST['formID']) && $_POST['formID'] === 'newUser') {
		$m_result = createAccount($_POST['FirstName'], $_POST['LastName'], $_POST['Mail'], $_POST['Password'], $_POST['Username']);
		if(is_string($m_result)) echo '<p class=error role=alert>'. $m_result .'</p>';
	// Login
	} else {
		// With password.
		if(isset($_POST['formID']) && $_POST['formID'] === 'login')
			$m_perms = getPerms($_POST['Username'], $_POST['Password']);
		// Login with token.
		else if(isset($_SESSION['loginToken']) && isset($_SESSION['ID']))
			$m_perms = getPerms($_SESSION['ID'], $_SESSION['loginToken']);
		if(is_string($m_perms)) {
			echo '<p class=error role=alert>'. $m_perms .'</p>';
			$m_perms = -1;
		}
	}
	if(isset($_POST['formID']) && $_POST['formID'] === 'updateUser' && $m_perms >= 0) {
		// setInfo($_SESSION['ID'], $_SESSION['pwdKey'], $_POST);
	}
	// This will assign the first non-null value (or null if there isn't one)
	$page = $_GET['page'] ?? $_POST['page'];
	// Return the default page if `page` is not defined.
	if(!isset($page)) return 'homepage.php';
	// Select page
	switch($page) {
		case 'build':
			return 'buildyourworkout.php';
		case 'prac':
			return 'oefeningen.html';
		case 'schema':
			return 'schema.html';
		case 'work':
			return 'workout.php';
		case 'info':
			return 'overons.php';
		case 'login':
			return 'login.html';
		case 'contact':
			return 'contact.php';
		case 'user':
			if($m_perms < 0) return 'homepage.php';
			return 'profilePage.php';
		case 'favorieten':
			return 'favorieten.php';
		case 'resultBYW':
			return 'resultBYW.php';
		default:
			return 'homepage.php';
	}
}