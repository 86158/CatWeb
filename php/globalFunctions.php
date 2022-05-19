<?php
require_once __DIR__.'/credentialFunctions.php';
/** Get the page.
 * @return string The url of the page to load.
*/
function returnPage(): string {
	// Find out the state of the user.
	$m_perms = -1;
	// Logout
	if(isset($_POST['logout']) || isset($_GET['logout'])) {
		session_unset();
	// Create new user.
	} elseif(isset($_POST['formID']) && $_POST['formID'] === 'newUser') {
		$m_result = createAccount($_POST['Username'], $_POST['Password'], $_POST['nameFirst'], $_POST['nameLast'], $_POST['street'], $_POST['postcode'], $_POST['city'], $_POST['country']);
		if(is_string($m_result)) echo '<p class=error role=alert>'. $m_result .'</p>';
	// Login
	} else {
		$m_perm = -1;
		// With password.
		if(isset($_POST['formID']) && $_POST['formID'] === 'login')
			$m_perm = getPerms($_POST['Username'], $_POST['Password']);
		// Login with token.
		else if(isset($_SESSION['loginToken']) && isset($_SESSION['ID']))
			$m_perm = getPerms($_SESSION['ID'], $_SESSION['loginToken']);
		if(is_string($m_perm))
			echo '<p class=error role=alert>'. $m_perm .'</p>';
		else $m_perms = $m_perm;
	}
	return '/pages/testPage.php';
	/*// TODO add page URIs
	switch($_GET['page']) {
		case 'permissionRequiringPage':
			if($m_perms < 0) return 'loginPageURI';
			return 'permissionRequiringPageURI';
		default:
			return 'mainPageURI';
	}*/
}