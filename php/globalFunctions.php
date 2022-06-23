<?php
// Ensure the functions we need are imported.
require_once __DIR__.'/credentialFunctions.php';
/** Function to go over the formdata and update fields */
function updateUser(): ?string {
	if((isset($_POST['FirstName']) && $_POST['FirstName'] != '') || (isset($_POST['LastName']) && $_POST['LastName'] != ''))
		setInfo($_SESSION['ID'], $_SESSION['pwdKey'], null, null, $_POST['FirstName'], $_POST['LastName']);
	if(isset($_POST['pwd_old']) && $_POST['pwd_old'] != '') {
		$m_info = getInfo();
		if(is_string($m_info)) return $m_info;
		$mail_new = null;
		if(isset($_POST['email']) && $_POST['email'] != '') {
			$mail_new = $_POST['email'];
		}
		$credentials_new = null;
		if(isset($_POST['pwd_new'])) {
			$pwd = $_POST['pwd_new'];
			$credentials_new = createPass($m_info['email'], $_POST['pwd_new'], $_POST['pwd_old'], $m_info['encryptedkey'], $mail_new);
		} elseif(isset($mail_new)) {
			$pwd = $_POST['pwd_old'];
			$credentials_new = createPass($m_info['email'], $_POST['pwd_old'], null, null, $mail_new);
		} else return null;
		if(!isset($credentials_new)) return 'Failed to generate new credentials. Check if the provided fields are valid.';
		$m_iv = '0000000000000069';
		$m_vars = [
			$m_info['email'],
			$m_info['username'], // Because username is used to login it's no longer encrypted
			password_hash($pwd . $m_info['email'], '2y'),	// Hash to verify if the password is correct.
			$credentials_new[0],	// encrypted_userKey
			// Data encrypted with userKey
			($m_info['FirstName'])?	openssl_encrypt($m_info['FirstName'],	'aes-256-cbc-hmac-sha256', $credentials_new[1], 0, $m_iv) : null,
			($m_info['LastName'])?	openssl_encrypt($m_info['LastName'],	'aes-256-cbc-hmac-sha256', $credentials_new[1], 0, $m_iv) : null,
			$_SESSION['ID'] // The ID of the user to change.
		];
		if($m_vars[2] === false) return 'Encryptie mislukt; Failed to create password hash';
		if(array_search(false, $m_vars, true) !== false) return 'Encryptie mislukt; Failed to openssl encrypt data';
		$m_return = DatbQuery(null, 'UPDATE `site_users` SET (`email`, `username`, `pwd`, `encryptedkey`, `FirstName`, `LastName`) VALUES (?, ?, ?, ?, ?, ?) WHERE `ID`=?', 'ssssssi', ...$m_vars);
		if(is_string($m_return)) return $m_return;
		return null;
	}
}
/** Get the page.
 * @return string The url of the page to load.
*/
function returnPage(): string {
	// perms is used to track the permission level of the user.
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
			// Rewrite the URL to include a login error message.
			$current_url = explode('?', $_SERVER['REQUEST_URI'])[0]; // Get the url without query params
			$request_uri = http_build_query(array_merge($_GET, ['alert'=>urlencode($m_perms)])); // Build a new query params
			header('Location: http://'. $_SERVER['HTTP_HOST'] . $current_url .'?'. $request_uri); // Rebuild the URL
			exit();
		}
	}
	if(isset($_POST['formID']) && $_POST['formID'] === 'updateUser' && $m_perms >= 0) {
		$m_result = updateUser();
		if(isset($m_result)) {
			// Rewrite the URL to include a error message.
			$current_url = explode('?', $_SERVER['REQUEST_URI'])[0]; // Get the url without query params
			$request_uri = http_build_query(array_merge($_GET, ['alert'=>urlencode($m_result)])); // Build a new query params
			header('Location: http://'. $_SERVER['HTTP_HOST'] . $current_url .'?'. $request_uri); // Rebuild the URL
			exit();
		}
	}
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} elseif(isset($_POST['page'])) {
		$page = $_POST['page'];
	}
	// Return the default page if `page` is not defined.
	if(!isset($page)) return 'homepage.html';
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
			if($m_perms < 0) return 'homepage.html';
			return 'profilePage.php';
		case 'favorieten':
			return 'favorieten.php';
		case 'resultBYW':
			return 'resultBYW.php';
		default:
			return 'homepage.html';
	}
}