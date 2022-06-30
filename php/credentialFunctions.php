<?php
// I need to find this in the options later.
// Reporting throws an error while I want to handle said errors in the code.
mysqli_report(MYSQLI_REPORT_OFF);
/**
 * Find the positions of the occurrences of a substring in a string
 * @param string $haystack The string to search in
 * @param string $needle  If needle is not a string, it is converted to an integer and applied as the ordinal value of a character.
 * @param int $offset If specified, search will start this number of characters counted from the beginning of the string. Unlike {@see strrpos()} and {@see strripos()}, the offset cannot be negative.
 * @return int[] Returns the positions where the needle exists relative to the beginning of the haystack string (independent of search direction or offset). Also note that string positions start at 0, and not 1.
 * @see https://stackoverflow.com/a/15737449
 */
function strpositions(string $haystack, string $needle, int $offset = 0): array {
	/** @var int[] $positions */
	$positions = [];
	while(($offset = strpos($haystack, $needle, $offset)) !== false) {
		/** @var int $offset */
		$positions[] = $offset;
		$offset += strlen($needle);
	}
	return $positions;
}
/**
 * Wrapper for class mysqli.
 * @param mysqli|null $conn The connection you want to use. Pass `null` to use a default mysqli() instance.
 * @param string $query SQL query without terminating semicolon or `\g` having its Data Manipulation Language (DML) parmeters replaced with `?` and put into `...$vars`
 * 
 * The length may not be larger than the max_allowed_packet size of the server.
 * @param string $types A string containing a single character for each arguments passed with `...$vars` depending on the type.
 * * 's' for strings
 * * 'd' for floats
 * * 'i' for integers
 * * 'b' for BLOBs
 * 
 * A BLOB is a string that exceeds the `max_allowed_packet` size of the server. It's send in a diffrent way.
 * @param string|int|float|null ...$vars
 * @return mysqli_result|string|int For errors it returns a string describing the error, for successful SELECT, SHOW, DESCRIBE or EXPLAIN queries a `mysqli_result` object. For other successful queries the number of affected rows.
 * @see https://php.net/manual/en/class.mysqli.php Used for the actual database communication.
 */
function DatbQuery(mysqli $conn = null, string $query, string $types = '', ...$vars) {
	$m_close = false;
	// Ensure types doesn't contain obvious errors.
	if(preg_match('/^[idsb]*$/', $types) != 1) return 'string $types contains invallid characters.';
	if(strlen($types) != count($vars)) return 'string $types should have the same length as the number of arguments passed with ...$vars'."\n". json_encode(['$types'=>$types,'...$vars'=>$vars, 'strlen($types)'=>strlen($types), 'count($vars)'=>count($vars)]);
	try {
		// Ensure connection
		if($conn == null) {
			$m_close = true;
			$conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
		}
		// Check if the connection succeeded.
		if($conn->connect_error) return $conn->connect_error;
		// Get the statement object and check for errors.
		$m_prep = $conn->prepare($query);
		if($m_prep == false)
			return $conn->error;
		// Attempt to bind parameters to their relative placeholders.
		if($types != '') {
			// Check if there are any blob values.
			if(strpos($types, 'b') === false) {
				if(!($m_prep->bind_param($types, ...$vars)))
					return $m_prep->error;
			// Handle blob values.
			} else {
				// Check the max length we may send at a time.
				try {
					$m_query = $conn->query('SELECT @@global.max_allowed_packet');
					$max_allowed_packet = $m_query->fetch_array(MYSQLI_NUM)[0];
				} finally {
					// Ensure all resources are closed to prevent memory leaks.
					$m_query->close();
				}
				if(!is_int($max_allowed_packet))
					return $conn->error;
				/** @var (string|int|float|null)[] $blobless A copy of $vars that had it's blob values replaced with null values.*/
				$blobless = $vars;
				/** @var int[] $long_data */
				$long_data = [];
				foreach(strpositions($types, 'b') as $index) {
					$blobless[$index] = null;
					$long_data[] = $index;
				}
				// Bind the data but use null for blobs.
				if(!($m_prep->bind_param($types, ...$blobless)))
					return $m_prep->error;
				// Split each blob into the maximum allowed size to send.
				foreach($long_data as $param_num) {
					/** @var string[]|false $split */
					$split = str_split($vars[$param_num], $max_allowed_packet);
					if($split === false)
						return '"SELECT @@global.max_allowed_packet" returned a value less than 1';
					// Send each part separately.
					foreach($split as $blob_part)
						if(!(mysqli_stmt_send_long_data($m_prep, $param_num, $blob_part)))
							return $m_prep->error;
				}
			}
		}
		// Execute the query.
		if(!$m_prep->execute())
			return $m_prep->error;
		// Get the results.
		$m_result = $m_prep->get_result();
		if($m_result == false)
			$m_result = ($m_prep->errno == 0)?
				$m_prep->affected_rows : $m_prep->error;
		return $m_result;
	} finally {
		// Ensure all resources are closed to prevent memory leaks.
		if(is_object($m_prep)) $m_prep->close();
		if(is_object($conn) && $m_close) $conn->close();
	}
}
/** Check the user credentials en permissions.
 * @param int|string $username If using a token use an `int` else it should be the email or username of the user as a `string`.
 * Usernames should not contain a `@` character.
 * @param string $pwd Password or token to be validated.
 * @return int|string Int representing permission level or a String containing an error message.
*/
function getPerms($username, string $pwd) {
	/** @param string $m_iv A non-NULL Initialization Vector.*/
	$m_iv = '0000000000000069';
	// Authentication with password
	if(is_string($username)) {
		$isMail = strpos($username, '@') != FALSE;
		// Get `pwd` to verify the given password with. `ID` so we know what user we have and `perms` for their permission level.
		try {
			if($isMail) {
				$m_output = DatbQuery(null, 'SELECT `ID`, `pwd`, `perms`, `email`, `username` FROM `site_users` WHERE `email`=?', 's', $username);
			} else {
				$m_output = DatbQuery(null, 'SELECT `ID`, `pwd`, `perms`, `email`, `username` FROM `site_users` WHERE `username`=?', 's', $username);
			}
			if(!is_object($m_output))
				return 'Database request failed at SELECT `pwd`';
			elseif($m_output->num_rows == 0)
				return 'Onbekende gebruiker';
			$m_result = $m_output->fetch_assoc();
		} finally {
			// Ensure all resources are closed to prevent memory leaks.
			if(is_object($m_output)) $m_output->close();
		}
		/** @var string $m_mail */
		$m_mail = $m_result['email'];
		if(!is_array($m_result) || !password_verify(($pwd . $m_mail), $m_result['pwd']))
			return 'Incorrecte gebruikersnaam/wachtwoord combination.';
		$permLevel = $m_result['perms'];
		// Create a login token as we should not store the password in the session.
		$m_ID = intval($m_result['ID']);
		$m_token = random_int(0, 16777215);
		$m_user = $m_result['username'];
		try {
			$m_output = DatbQuery(null, "UPDATE `site_users` SET `token`=?, `tokenTime` = NOW() WHERE `ID`=?", 'ii', $m_token, $m_ID);
			if($m_output !== 1) return 'Database request failed at UPDATE `users` SET `token`';
		} finally {
			// Ensure all resources are closed to prevent memory leaks.
			if(is_object($m_output)) $m_output->close();
		}
		// Using a encrypted email as the Key Encryption Key. The Data Encryption Key is never even put in $_SESSION
		$m_pwdKey = openssl_encrypt($m_mail, 'aes-256-cbc-hmac-sha256', $pwd, 0, $m_iv);
		if($m_pwdKey === false)
			return 'Failed to encrypt pwdKey';
		// Store `ID` and info of the user.
		$_SESSION['ID'] = $m_ID;
		$_SESSION['loginToken'] = $m_token;
		$_SESSION['username'] = $m_user;
		$_SESSION['pwdKey'] = $m_pwdKey;
		// Authentication with token
	} else {
		// Get the token.
		try {
			$m_output = DatbQuery(null, 'SELECT `token`, TIMESTAMPDIFF(MINUTE, `tokenTime`, NOW()) as `timeDif`, `perms` FROM `site_users` WHERE `ID`=?', 'i', $username);
			if(!is_object($m_output) || $m_output->num_rows == 0) {
				unset($_SESSION['loginToken'], $_SESSION['ID'], $_SESSION['username'], $_SESSION['pwdKey']);
				return 'Database request failed at SELECT `token`';
			}
			$m_result = $m_output->fetch_assoc();
		} finally {
			// Ensure all resources are closed to prevent memory leaks.
			$m_output->close();
		}
		$permLevel = $m_result['perms'];
		if(!is_array($m_result)) {
			unset($_SESSION['loginToken'], $_SESSION['ID'], $_SESSION['username'], $_SESSION['pwdKey']);
			return 'Invallid/expired loginToken.';
		}
		// Ensure the token is the same as the one given and ensure it has not expired.
		if($m_result['token'] != $pwd || $m_result['timeDif'] > 15) {
			try {
				$m_result = DatbQuery(null, 'UPDATE IGNORE `users` SET `token`=NULL, `tokenTime`=NULL WHERE `ID`=?', 'i', $username);
			} finally {
				// Ensure all resources are closed to prevent memory leaks.
				if(is_object($m_result)) $m_result->close();
			}
			unset($_SESSION['loginToken'], $_SESSION['ID'], $_SESSION['username'], $_SESSION['pwdKey']);
			return 'Invallid/expired loginToken.';
		}
	}
	return $permLevel;
}
/**
 * @see https://security.stackexchange.com/a/182008 How we handle authentication and encryption.
 * @return array<int,string>|null [encrypted_userKey, userKey]
 */
function createPass(string $email, string $pwd, ?string $pwd_old = null, ?string $encryptedKey_old = null, ?string $email_new = null): ?array {
	if(!(
		preg_match('/^[\w!#$%&\'*+\-\/=?\^_`{|}~]+(?:\.[\w!#$%&\'*+\-\/=?\^_\`{|}~]+)*@(?:(?:(?:[\-\w]+\.)+[a-zA-Z]{2,4})|(?:(?:[0-9]{1,3}\.){3}[0-9]{1,3}))$/', $email)
		&& (
			$email_new == null ||
			preg_match('/^[\w!#$%&\'*+\-\/=?\^_`{|}~]+(?:\.[\w!#$%&\'*+\-\/=?\^_\`{|}~]+)*@(?:(?:(?:[\-\w]+\.)+[a-zA-Z]{2,4})|(?:(?:[0-9]{1,3}\.){3}[0-9]{1,3}))$/', $email_new)
		) &&
		preg_match('/^\S+$/', $pwd)
	)) return null;
	$m_iv = '0000000000000069';
	// Derive old password key from old password and new password key from new password.
	/** @var string|false $m_pwdkey_old Old Encryption Key*/
	$m_pwdKey_old = openssl_encrypt($email, 'aes-256-cbc-hmac-sha256', $pwd_old, 0, $m_iv);
	/** @var string|false $m_pwdkey_new New Key Encryption Key*/
	$m_pwdkey_new = ($email_new)?
	openssl_encrypt($email_new, 'aes-256-cbc-hmac-sha256', $pwd, 0, $m_iv) :
	openssl_encrypt($email, 'aes-256-cbc-hmac-sha256', $pwd, 0, $m_iv);
	// Decrypt user-key using old key
	/** @var string|false $m_userKey Data Encryption Key*/
	$m_userKey = (isset($encryptedKey_old))? openssl_decrypt($encryptedKey_old, 'aes-256-cbc-hmac-sha256', $m_pwdKey_old, 0, $m_iv) : random_bytes(60);
	if($m_userKey === false || $m_pwdkey_new == false) return null;
	// Encrypt user-key with new key
	$m_encrypted_userKey = openssl_encrypt($m_userKey, 'aes-256-cbc-hmac-sha256', $m_pwdkey_new, 0, $m_iv);
	if($m_encrypted_userKey === false) return null;
	return [$m_encrypted_userKey, $m_userKey];
}
/** How to get the encrypted data
 * @param mysqli|null $conn The connection you want to use. Pass `null` to use a default mysqli() instance.
 * @param int $id The id of the user to get info on.
 * @param string $pwdKey The key to decrypt the encryptedkey with.
 * @see https://security.stackexchange.com/a/182008 How we handle authentication and encryption.
 * @return array<string,string|false|null>|string Array with the decoded data from the database with false on failure or a string with error message.
*/
function getInfo(mysqli $conn = null, int $id, string $pwdKey) {
	$m_close = false;
	try {
		// Ensure connection
		if($conn == null) {
			$m_close = true;
			$conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
		}
		$m_output = DatbQuery($conn, 'SELECT `encryptedkey`, `email`, `username`, `FirstName`, `LastName` FROM `site_users` WHERE `ID`=?', 'i', $id);
		if(!is_object($m_output))
			return 'Database request mislukt at SELECT `encryptedkey`';
		if($m_output->num_rows == 0) {
			return 'Database returned a empty result set';
		}
		$m_result = $m_output->fetch_assoc();
	} finally {
		if(is_object($m_output)) $m_output->close();
		if(is_object($conn) && $m_close) $conn->close();
	}
	$m_iv = '0000000000000069';
	$m_userKey = openssl_decrypt($m_result['encryptedkey'], 'aes-256-cbc-hmac-sha256', $pwdKey, 0, $m_iv);
	if(!is_string($m_userKey)) return 'Decryption failed';
	// We put the data in a relative array decrypting it first if it is not null.
	/** @var array<string,(string|false|null)> $decryptedData */
	$decryptedData = [
		'email' => $m_result['email'],
		'username'	=> $m_result['username'],
		'encryptedkey' => $m_result['encryptedkey'],
		'FirstName'	=> ($m_result['FirstName'])?	openssl_decrypt($m_result['FirstName'],	'aes-256-cbc-hmac-sha256', $m_userKey, 0, $m_iv) : null,
		'LastName'	=> ($m_result['LastName'])?	openssl_decrypt($m_result['LastName'],	'aes-256-cbc-hmac-sha256', $m_userKey, 0, $m_iv) : null
	];
	return $decryptedData;
}
/** Update/change user info
 * @see https://security.stackexchange.com/a/182008 How we handle authentication and encryption.
 * @deprecated Use {@see modifyAccount()} instead
 */
function setInfo(int $id, string $pwdKey, ?string $username = null, ?int $perms = null, ?string $FirstName = null, ?string $LastName = null): ?string {
	$m_conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
	// Check if the connection succeeded.
	if($m_conn->connect_error) return $m_conn->connect_error;
	$m_output = DatbQuery($m_conn, 'SELECT `encryptedkey` FROM `site_users` WHERE `ID`=?', 'i', $id);
	if(!is_object($m_output) || $m_output->num_rows == 0)
		return 'Database request mislukt at SELECT `encryptedkey`';
	$m_result = $m_output->fetch_assoc();
	$m_output->close();
	// Unasign mysqli handle because using close when already closed creates an exception instead of returning false like it should.
	$m_output = null;
	$m_iv = '0000000000000069';
	$m_userKey = openssl_decrypt($m_result['encryptedkey'], 'aes-256-cbc-hmac-sha256', $pwdKey, 0, $m_iv);
	if($m_userKey == false) return 'Decryption failed';
	/** @var array<int,mysqli_result|string|int> $m_results */
	$m_results = [];
	// We basically go over all given arguments and change those that are set.
	if(isset($username) && $username != '')
		$m_results[] = DatbQuery($m_conn, 'UPDATE `site_users` SET `username`=? WHERE `ID`=?', 'si', $username, $id);
	if(isset($perms))
		$m_results[] = DatbQuery($m_conn, 'UPDATE `site_users` SET `perms`=? WHERE `ID`=?', 'ii', $perms, $id);
	if(isset($FirstName) && $FirstName != '')
		$m_results[] = DatbQuery($m_conn, 'UPDATE `site_users` SET `FirstName`=? WHERE `ID`=?', 'si', openssl_encrypt($FirstName, 'aes-256-cbc-hmac-sha256', $m_userKey, 0, $m_iv), $id);
	if(isset($LastName) && $LastName != '')
		$m_results[] = DatbQuery($m_conn, 'UPDATE `site_users` SET `LastName`=? WHERE `ID`=?', 'si', openssl_encrypt($LastName, 'aes-256-cbc-hmac-sha256', $m_userKey, 0, $m_iv), $id);
	$m_conn->close();
	$m_error = array_filter($m_results, function($value): bool {
		$result = !is_int($value);
		if($value instanceof mysqli_result) $value->close();
		return $result;
	});
	if(count($m_error) != 0) return strval($m_error[0]);
	return null;
}
/**
 * Create a new account with encrypted personal details.
 * @param mysqli|null $conn The connection you want to use. Pass `null` to use a default `mysqli()` instance.
 * @param string $email The email of the user.
 * @param string $pwd The password to use for the user.
 * @param ?string $username The username the user goes by. Defaults to `null`.
 * @param int $perms The permission level of the user. Defaults to `0`.
 * @param ?string $FirstName The FistName of the user. Defaults to `null`.
 * @param ?string $LastName The LastName of the user. Defaults to `null`.
 * @return null|string `null` on success. Error message on failure.
*/
function createAccount(mysqli $conn = null, string $email, string $pwd, ?string $username = null, int $perms = 0, ?string $FirstName = null, ?string $LastName = null): ?string {
	$m_close = false;
	// Verify contents
	if(!preg_match('/^[\w!#$%&\'*+\-\/=?\^_`{|}~]+(?:\.[\w!#$%&\'*+\-\/=?\^_\`{|}~]+)*@(?:(?:(?:[\-\w]+\.)+[a-zA-Z]{2,4})|(?:(?:[0-9]{1,3}\.){3}[0-9]{1,3}))$/', $email)) return 'Incorrect e-mail format';
	if(!preg_match('/^[^\0\n\f\r\t\v]+$/', $pwd)) return 'Invallid characters in password';
	if(isset($username) && !preg_match('/^\w+$/', $username)) return 'Invallid characters in username';
	if(isset($FirstName) && !preg_match('/^\w+$/', $FirstName)) return 'Invallid characters in FirstName';
	if(isset($LastName) && !preg_match('/^\w+$/', $LastName)) return 'Invallid characters in LastName';
	$m_pass = createPass($email, $pwd);
	if($m_pass === null) return 'Encryptie mislukt; Failed to openssl encrypt data';
	$m_iv = '0000000000000069';
	$m_vars = [
		$email,
		$username, // Because username is used to login it's no longer encrypted
		password_hash($pwd . $email, '2y'),	// Hash to verify if the password is correct.
		$m_pass[0],	// encrypted_userKey
		$perms,
		// Data encrypted with userKey
		($FirstName)?	openssl_encrypt($FirstName,	'aes-256-cbc-hmac-sha256', $m_pass[1], 0, $m_iv) : null,
		($LastName)?	openssl_encrypt($LastName,	'aes-256-cbc-hmac-sha256', $m_pass[1], 0, $m_iv) : null
	];
	if($m_vars[2] === false) return 'Encryptie mislukt; Failed to create password hash';
	if(array_search(false, $m_vars, true) !== false) return 'Encryptie mislukt; Failed to openssl encrypt data';
	try {
		// Ensure connection
		if($conn == null) {
			$m_close = true;
			$conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
		}
		$m_output = DatbQuery($conn, 'INSERT INTO `site_users` (`email`, `username`, `pwd`, `encryptedkey`, `perms`, `FirstName`, `LastName`) VALUES (?, ?, ?, ?, ?, ?, ?)', 'ssssiss', ...$m_vars);
		if(is_string($m_output)) return $m_output;
		return null;
	} finally {
		// Ensure all resources are closed to prevent memory leaks.
		if(is_object($m_output)) $m_output->close();
		if($m_close && is_object($conn)) $conn->close();
	}
}
/** Modify data in the account and generate a new userKey to encrypt the data with.
 * @param mysqli|null $conn The connection you want to use. Pass `null` to use a default mysqli() instance.
 * @param string|int $user The email, username or ID of the account.
 * @param string $pwd The current password of the account.
 * @param ?string $pwd_new The replacement password of the account or `null` to keep the current value.
 * @param ?string $email_new The replacement email of the account or `null` to keep the current value.
 * @param ?string $username The replacement username of the account or `null` to keep the current value.
 * @param ?int $perms The new permlevel of the account or `null` to keep the current value.
 * @param ?string $FirstName The new FirstName of the account or `null` to keep the current value.
 * @param ?string $LastName The new LastName of the account or `null` to keep the current value.
 * @return ?string `null` on a success and a string describing the error on a failure.
 */
function modifyAccount(?mysqli $conn = null, $user, string $pwd, ?string $pwd_new = null, ?string $email_new, ?string $username = null, ?int $perms = null, ?string $FirstName = null, ?string $LastName = null): ?string {
	$m_close = false;
	try {
		// Ensure connection
		if($conn == null) {
			$m_close = true;
			$conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
		}
		// Get the original values.
		$m_output = 'Failed to find current user';
		if(is_int($user))
			$m_output = DatbQuery($conn, 'SELECT `ID`, `email`, `username`, `pwd`, `encryptedkey`, `perms`, `FirstName`, `LastName` FROM `site_users` WHERE `ID`=?', 'i', $user);
		elseif(strpos($user, '@') !== false)
			$m_output = DatbQuery($conn, 'SELECT `ID`, `email`, `username`, `pwd`, `encryptedkey`, `perms`, `FirstName`, `LastName` FROM `site_users` WHERE `email`=?', 's', $user);
		else
			$m_output = DatbQuery($conn, 'SELECT `ID`, `email`, `username`, `pwd`, `encryptedkey`, `perms`, `FirstName`, `LastName` FROM `site_users` WHERE `username`=?', 's', $user);
		if(!is_object($m_output) || $m_output->num_rows == 0)
			return 'Database request failed at SELECT *';
		/** @var array<string|null|int>|null $m_result */
		$m_result = $m_output->fetch_assoc();
		$m_output->close();
		// Unasign mysqli handle because using close when already closed creates an exception instead of returning false like it should.
		$m_output = null;
		if(!is_array($m_result)) return 'Empty result set.';
		// Check if the password is correct.
		if(!password_verify(($pwd . $m_result['email']), $m_result['pwd']))
			return 'Incorrecte gebruikersnaam/wachtwoord combination.';
		$m_iv = '0000000000000069';
		// Get the old pwdKey and userKey.
		$m_pwdKey_old = openssl_encrypt($m_result['email'], 'aes-256-cbc-hmac-sha256', $pwd, 0, $m_iv);
		$m_userKey_old = openssl_decrypt($m_result['encryptedkey'], 'aes-256-cbc-hmac-sha256', $m_pwdKey_old, 0, $m_iv);
		if($m_pwdKey_old === false || $m_userKey_old === false)
			return 'Failed to decrypt the encryptedkey';
		// If the new values are not acceptable the old values are used.
		if(!isset($pwd_new) || !preg_match('/^[^\0\n\f\r\t\v]+$/', $pwd_new))
			$pwd_new = $pwd;
		if(!isset($email_new) || !preg_match('/^[\w!#$%&\'*+\-\/=?\^_`{|}~]+(?:\.[\w!#$%&\'*+\-\/=?\^_\`{|}~]+)*@(?:(?:(?:[\-\w]+\.)+[a-zA-Z]{2,4})|(?:(?:[0-9]{1,3}\.){3}[0-9]{1,3}))$/', $email_new))
			$email_new = $m_result['email'];
		// Generate a new userKey, pwdkey and encrypted userkey.
		$m_userKey_new = random_bytes(60);
		$m_pwdkey_new = openssl_encrypt($m_result['email'], 'aes-256-cbc-hmac-sha256', $pwd_new, 0, $m_iv);
		if($m_pwdkey_new === false) return 'Failed to create new pwdkey';
		$m_encryptedkey_new = openssl_encrypt($m_userKey_new, 'aes-256-cbc-hmac-sha256', $m_pwdkey_new, 0, $m_iv);
		if($m_encryptedkey_new === false) return 'Failed to create new encryptedkey';
		// If the new values are not acceptable the old values are used.
		if(!isset($username) || !preg_match('/^\w+$/', $username))
			$username = $m_result['username'];
		if(!isset($perms))
			$perms = $m_result['perms'];
		if(!isset($FirstName) || !preg_match('/^\w+$/', $FirstName))
			$FirstName	=	($m_result['FirstName'])?	openssl_decrypt($m_result['FirstName'],	'aes-256-cbc-hmac-sha256', $m_userKey_old, 0, $m_iv) : null;
		if(!isset($LastName) || !preg_match('/^\w+$/', $LastName))
			$LastName	=	($m_result['LastName'])?	openssl_decrypt($m_result['LastName'],		'aes-256-cbc-hmac-sha256', $m_userKey_old, 0, $m_iv) : null;
		if($FirstName === false || $LastName === false)
			return 'Failed to decrypt original values';
		if(isset($FirstName))
			$FirstName = openssl_encrypt($FirstName,	'aes-256-cbc-hmac-sha256', $m_userKey_new, 0, $m_iv);
		if(isset($LastName))
			$LastName = openssl_encrypt($LastName,	'aes-256-cbc-hmac-sha256', $m_userKey_new, 0, $m_iv);
		if($FirstName === false || $LastName === false)
			return 'Failed to encrypt new values';
		// Use UPDATE to prevent overwriting other existing users.
		$m_output = DatbQuery($conn,
			'UPDATE `site_users` SET `email` = ?, `username` = ?, `pwd` = ?, `encryptedkey` = ?, `perms` = ?, `FirstName` = ?, `LastName` = ?, `token` = NULL, `tokenTime` = NULL WHERE `ID` = ?',
			'ssssissi',
			$email_new, $username, password_hash($pwd_new . $email_new, '2y'), $m_encryptedkey_new, $perms, $FirstName, $LastName, $m_result['ID']
		);
		$m_return = null;
		if($m_result !== 1)
			$m_return = (is_string($m_output))? $m_output : "Failed to replace database entry.\nTrace: `". var_export($m_output, true) .'`';
		return $m_return;
	} finally {
		// Ensure all resources are closed to prevent memory leaks.
		if(is_object($m_output)) $m_output->close();
		if(is_object($conn) && $m_close) $conn->close();
	}
}