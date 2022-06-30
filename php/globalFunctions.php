<?php
// Ensure the functions we need are imported.
require_once __DIR__.'/credentialFunctions.php';
/** Function to go over the formdata and update fields */
function updateUser(): ?string {
	$m_vars = [
		'conn' => null,
		'user' => null,
		'pwd' => null,
		'pwd_new' => null,
		'email_new' => null,
		'username' => null,
		'perms' => null,
		'FirstName' => null,
		'LastName' => null
	];
	if(isset($_SESSION['ID']) && is_int($_SESSION['ID']))
		$m_vars['user'] = $_SESSION['ID'];
	else return 'Incorrect/missing ID';
	if(isset($_POST['pwd_old']) && is_string($_POST['pwd_old']))
		$m_vars['pwd'] = $_POST['pwd_old'];
	if(isset($_POST['pwd_new']) && is_string($_POST['pwd_new']))
		$m_vars['pwd_new'] = $_POST['pwd_new'];
	if(isset($_POST['email']) && is_string($_POST['email']))
		$m_vars['email_new'] = $_POST['email'];
	// Username is not a form option so it's skipped
	// Perms are not changed with this so it's skipped
	if(isset($_POST['FirstName']) && is_string($_POST['FirstName']))
		$m_vars['FirstName'] = $_POST['FirstName'];
	if(isset($_POST['LastName']) && is_string($_POST['LastName']))
		$m_vars['LastName'] = $_POST['LastName'];
	var_dump($m_vars);
	return modifyAccount(...$m_vars);
}
/** Get the page.
 * @return string The url of the page to load.
*/
function returnPage(): string {
	// perms is used to track the permission level of the user.
	$m_perms = -1;
	// Logout
	if(isset($_POST['logout'])) {
		// Mark login tokens as invallid if loggin out.
		if(isset($_SESSION['ID'])) {
			try {
				$m_result = DatbQuery(null, 'UPDATE IGNORE `users` SET `token`=NULL, `tokenTime`=NULL WHERE `ID`=?', 'i', $_SESSION['ID']);
			} finally {
				// Ensure all resources are closed to prevent memory leaks.
				if(is_object($m_result)) $m_result->close();
				unset($m_result);
			}
		}
		session_unset();
		// Rewrite the URL to remove login error messages.
		$current_url = explode('?', $_SERVER['REQUEST_URI'])[0]; // Get the url without query params
		header('Location: http://'. $_SERVER['HTTP_HOST'] . $current_url); // Rebuild the URL
		exit();
	// Create new user.
	} elseif(isset($_POST['formID']) && $_POST['formID'] === 'newUser') {
		$m_result = createAccount(null, $_POST['Mail'], $_POST['Password'], $_POST['Username'], 0, $_POST['FirstName'], $_POST['LastName']);
		if(is_string($m_result)) $m_perms = $m_result;
	// Login
	} else {
		// With password.
		if(isset($_POST['formID']) && $_POST['formID'] === 'login')
			$m_perms = getPerms(strval($_POST['Username']), $_POST['Password']);
		// Login with token.
		elseif(isset($_SESSION['loginToken']) && isset($_SESSION['ID'])) {
			$m_perms = getPerms(intval($_SESSION['ID']), $_SESSION['loginToken']);
		}
	}
	if(is_string($m_perms)) {
		// Rewrite the URL to include a login error message.
		$current_url = explode('?', $_SERVER['REQUEST_URI'])[0]; // Get the url without query params
		$request_uri = http_build_query(['page'=>'home', 'alert'=>urlencode($m_perms)]); // Build a new query params
		header('Location: http://'. $_SERVER['HTTP_HOST'] . $current_url .'?'. $request_uri); // Rebuild the URL
		exit();
	}
	if(isset($_POST['formID']) && $_POST['formID'] === 'updateUser' && $m_perms >= 0) {
		$m_result = updateUser();
		// Rewrite the URL to include a error message.
		$current_url = explode('?', $_SERVER['REQUEST_URI'])[0]; // Get the url without query params
		// Build a new query params
		$request_uri = isset($m_result)?
			http_build_query(['page'=>'user','alert'=>urlencode($m_result)]) :
			http_build_query(['page'=>'home','alert'=>urlencode('Changed profile information.')]);
		header('Location: http://'. $_SERVER['HTTP_HOST'] . $current_url .'?'. $request_uri); // Rebuild the URL
		exit();
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
		case 'savedSchema':
			return 'savedSchema.php';
		case 'resultBYW':
			return 'resultBYW.php';
		default:
			return 'homepage.html';
	}
}