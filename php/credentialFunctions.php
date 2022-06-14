<?php
// I need to find this in the options later.
// Reporting throws an error while I want to handle said errors in the code.
mysqli_report(MYSQLI_REPORT_OFF);
/**
 * Find the positions of the occurrences of a substring in a string
 * @param string $haystack The string to search in
 * @param string $needle  If needle is not a string, it is converted to an integer and applied as the ordinal value of a character.
 * @param int $offset If specified, search will start this number of characters counted from the beginning of the string. Unlike {@see strrpos()} and {@see strripos()}, the offset cannot be negative.
 * @return int[] Returns the positions where the needle exists relative to the beginnning of the haystack string (independent of search direction or offset). Also note that string positions start at 0, and not 1.
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
 * @param mysqli|null $conn The connection you want to use. Pass null to use a default mysqli() instance.
 * @param string $query SQL query wihout terminating semicolon or \g having its Data Manipulation Language (DML) parmeters replaced with `?` and put into ...$vars
 * 
 * The lenght may not be larger than the max_allowed_packet size of the server.
 * @param string $types A string containing a single character for each arguments passed with ...$vars depending on the type.
 * * 's' for strings
 * * 'd' for floats
 * * 'i' for integers
 * * 'b' for BLOBs
 * 
 * A BLOB is a string that exceeds the max_allowed_packet size of the server. It's send in a diffrent way.
 * @param string|int|float|null ...$vars
 * @return mysqli_result|string|int For errors it returns a string, for successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query will return a mysqli_result object. For other successful queries mysqli_query will return the number of affected rows.
 * @throws InvalidArgumentException If $types does not match the constrants.
 * @see https://php.net/manual/en/class.mysqli.php Used for the actual database comminucation.
 */
function DatbQuery(mysqli $conn = null, string $query, string $types = '', ...$vars) {
	// Ensure types doesn't contain obvious errors.
	if(preg_match('/^[idsb]*$/', $types) != 1) throw new InvalidArgumentException('string $types contains invallid characters.');
	if(strlen($types) != count($vars)) throw new InvalidArgumentException('string $types should have the same length as the number of arguments passed with ...$vars'."\n". json_encode(['$types'=>$types,'...$vars'=>$vars, 'strlen($types)'=>strlen($types), 'count($vars)'=>count($vars)]));
	// Ensure connection
	$m_close = false;
	if($conn == null) {
		$conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
		$m_close = true;
	}
	// Check if the connection succeeded.
	if($conn->connect_error) return $conn->connect_error;
	// Get the statement object and check for errors.
	$m_prep = $conn->prepare($query);
	if($m_prep == false) {
		$error = $conn->error;
		if($m_close) $conn->close();
		return $error;
	}
	// Attempt to bind parameters to their relative placeholders.
	if($types != '') {
		// Check if there are any blob values.
		if(strpos($types, 'b') === false) {
			if(!($m_prep->bind_param($types, ...$vars))) {
				$error = $m_prep->error;
				$m_prep->close(); if($m_close) $conn->close();
				return $error;
			}
		// Handle blob values.
		} else {
			// Check the max lenght we may send at a time.
			$maxp = $conn->query('SELECT @@global.max_allowed_packet')->fetch_array(MYSQLI_NUM)[0];
			if(!is_int($maxp)) {
				$error = $conn->error;
				if($m_close) $conn->close();
				return $error;
			}
			/** @var (string|int|float|null)[] $blobless A copy of $vars that had it's blob values replaced with null values.*/
			$blobless = $vars;
			/** @var int[] $long_data */
			$long_data = [];
			foreach(strpositions($types, "b") as $index) {
				$blobless[$index] = null;
				$long_data[] = $index;
			}
			// Bind the data but use null for blobs.
			if(!($m_prep->bind_param($types, ...$blobless))) {
				$error = $m_prep->error;
				$m_prep->close(); if($m_close) $conn->close();
				return $error;
			}
			// Split each blob into the maxiumum allowed size to send.
			foreach($long_data as $param_num) {
				/** @var string[]|false $split */
				$split = str_split($vars[$param_num], $maxp);
				if($split === false) {
					$m_prep->close(); if($m_close) $conn->close();
					return '"SELECT @@global.max_allowed_packet" returned a value less than 1';
				}
				// Send each part seperately.
				foreach($split as $blob_part) {
					if(!(mysqli_stmt_send_long_data($m_prep, $param_num, $blob_part))) {
						$error = $m_prep->error;
						$m_prep->close(); if($m_close) $conn->close();
						return $error;
					}
				}
			}
		}
	}
	// Execute the querry.
	if(!$m_prep->execute()) {
		$error = $m_prep->error;
		$m_prep->close(); if($m_close) $conn->close();
		return $error;
	}
	// Get the results.
	$m_result = $m_prep->get_result();
	if($m_result == false)
		$m_result = ($m_prep->errno == 0)?
			$m_prep->affected_rows : $m_prep->error;
	// close connection
	$m_prep->close();
	if($m_close) $conn->close();
	return $m_result;
}
/** Check the user credentials en permissions.
 * @param int|string $username If using a token use an `int` else it should be the email or username of the user as a `string`.
 * Usernames should not contain a `@` character.
 * @param string $pwd Password or token to be validated.
 * @return int|string Int representing permission level or a String containing an error message.
*/
function getPerms($username, string $pwd) {
	/** @param string $m_iv A non-NULL Initialization Vector.*/
	$m_iv = "0000000000000069";
	// Autentication with password
	if(is_string($username)) {
		$isMail = strpos($username, "@") != FALSE;
		// Get `pwd` to verify the given password with. `ID` so we know what user we have and `perms` for their permission level.
		if($isMail) {
			$m_result = DatbQuery(null, 'SELECT `ID`, `pwd`, `perms`, `email` FROM `site_users` WHERE `email`=?', 's', $username);
		} else {
			$m_result = DatbQuery(null, 'SELECT `ID`, `pwd`, `perms`, `email` FROM `site_users` WHERE `username`=?', 's', $username);
		}
		if(!is_object($m_result))
			return 'Database request failed at SELECT `pwd`';
		$m_result = $m_result->fetch_assoc();
		if(!is_array($m_result) || !password_verify(($pwd . $m_result['email']), $m_result['pwd']))
			return 'Incorrecte gebruikersnaam, wachtwoord combination.';
		$permLevel = $m_result['perms'];
		// Create a login token as we should not store the password in the session.
		$m_ID = intval($m_result['ID']);
		$m_token = random_int(0, 16777215);
		$m_result = DatbQuery(null, "UPDATE `site_users` SET `token`=?, `tokenTime` = NOW() WHERE `ID`=?", 'ii', $m_token, $m_ID);
		if($m_result !== 1)
			return 'Database request failed at UPDATE `users` SET `token`';
		// Store `ID` of the user and their token.
		$_SESSION['ID'] = $m_ID;
		$_SESSION['loginToken'] = $m_token;
		// Using a encrypted username as the Key Encryption Key. The Data Encryption Key is never put in $_SESSION
		$_SESSION['pwdKey'] = openssl_encrypt($username, 'aes-256-cbc-hmac-sha256', $pwd, 0, $m_iv);
		// Autentication with token
	} else {
		// Get the token.
		$m_result = DatbQuery(null, 'SELECT `token`, TIMESTAMPDIFF(MINUTE, `tokenTime`, NOW()) as `timeDif`, `perms` FROM `site_users` WHERE `ID`=?', 'i', $username);
		if(!is_object($m_result))
			return 'Database request failed at SELECT `token`';
		$m_result = $m_result->fetch_assoc();
		$permLevel = $m_result['perms'];
		if(!is_array($m_result)) {
			unset($_SESSION['loginToken']);
			return 'Invallid/expired loginToken.';
		}
		// Ensure the token is the same as the one given and ensure it has not expired.
		if($m_result['token'] != $pwd || $m_result['timeDif'] > 15) {
			DatbQuery(null, 'UPDATE IGNORE `users` SET `token`=NULL, `tokenTime`=NULL WHERE `ID`=?', 'i', $username);
			unset($_SESSION['loginToken']);
			return 'Invallid/expired loginToken.';
		}
	}
	return $permLevel;
}
/**
 * @see https://security.stackexchange.com/a/182008 How we handle autentication and encryption.
 * @return array<int,string>|null [encrypted_userKey, userKey]
 */
function createPass(string $email, string $pwd, ?string $pwd_old = null, ?string $encryptedKey_old = null): ?array {
	$m_iv = "0000000000000069";
	// Derive old password key from old password and new password key from new password.
	/** @var string|false $m_pwdkey_old Old Encryption Key*/
	$m_pwdKey_old = openssl_encrypt($email, 'aes-256-cbc-hmac-sha256', $pwd_old, 0, $m_iv);
	/** @var string|false $m_pwdkey_new New Key Encryption Key*/
	$m_pwdkey_new = openssl_encrypt($email, 'aes-256-cbc-hmac-sha256', $pwd, 0, $m_iv);
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
 * @see https://security.stackexchange.com/a/182008 How we handle autentication and encryption.
 * @return array<string,string|false|null>|string Array with the decoded data from the database with false on failure or a string with error message.
*/
function getInfo() {
	$id = $_SESSION['ID'];
	$pwdKey = $_SESSION['pwdKey'];
	$m_iv = "0000000000000069";
	$m_result = DatbQuery(null, 'SELECT `encryptedkey`, `username` FROM `site_users` WHERE `ID`=?', 'i', $id);
	if(!is_object($m_result))
		return 'Database request mislukt at SELECT `encryptedkey`';
	$m_result = $m_result->fetch_assoc();
	$m_userKey = openssl_decrypt($m_result['encryptedkey'], 'aes-256-cbc-hmac-sha256', $pwdKey, 0, $m_iv);
	if(!is_string($m_userKey)) return 'Decryption failed';
	// We put the data in a relative array decrypting it first if it is not null.
	/** @var array<string,(string|false|null)> $decryptedData */
	$decryptedData = [
		'username'	=> ($m_result['username'])?	openssl_decrypt($m_result['nameFirst'],	'aes-256-cbc-hmac-sha256', $m_userKey, 0, $m_iv) : null
	];
	return $decryptedData;
}
/** Update/change user info
 * @see https://security.stackexchange.com/a/182008 How we handle autentication and encryption.
 */
function setInfo(int $id, string $pwdKey, ?string $username = null, ?int $perms = null): ?string {
	$m_iv = "0000000000000069";
	$m_conn = new mysqli('127.0.0.1', 'root', '', 'catweb', 3306);
	// Check if the connection succeeded.
	if($m_conn->connect_error) return $m_conn->connect_error;
	$m_result = DatbQuery($m_conn, 'SELECT `encryptedkey` FROM `site_users` WHERE `ID`=?', 'i', $id);
	if(!is_object($m_result))
		return 'Database request mislukt at SELECT `email`';
	$m_result = $m_result->fetch_assoc();
	$m_userKey = openssl_decrypt($m_result['encryptedkey'], 'aes-256-cbc-hmac-sha256', $pwdKey, 0, $m_iv);
	if($m_userKey == false) return 'Decryption failed';
	$m_results = [];
	// We basically go over all given arguments and change those that are set.
	if(isset($username))
		$m_results[] = DatbQuery($m_conn, 'UPDATE `site_users` SET `username`=? WHERE `ID`=?', 'si', openssl_encrypt($username, 'aes-256-cbc-hmac-sha256', $m_userKey, 0, $m_iv), $id);
	if(isset($perms))
		$m_results[] = DatbQuery($m_conn, 'UPDATE `site_users` SET `perms`=? WHERE `ID`=?', 'ii', $perms, $id);
	$m_conn->close();
	return null;
}
/**
 * Create a new account with encrypted personal details.
 * @return null|string null on success. Error message on failure.
*/
function createAccount(string $FirstName, string $LastName, string $email, string $pwd, ?string $username = null, int $perms = 0): ?string {
	// Verify contents
	if(!preg_match('/^[\w!#$%&\'*+\-\/=?\^_`{|}~]+(?:\.[\w!#$%&\'*+\-\/=?\^_\`{|}~]+)*@(?:(?:(?:[\-\w]+\.)+[a-zA-Z]{2,4})|(?:(?:[0-9]{1,3}\.){3}[0-9]{1,3}))$/', $email)) return 'Incorrect e-mail format';
	if($username != null && !preg_match('/^[\w]+$/', $username)) return 'Incorrect username format';
	// $m_iv = "0000000000000069";
	$m_pass = createPass($email, $pwd);
	if($m_pass === null) return 'Encryptie mislukt; Failed to openssl encrypt data';
	$m_vars = [
		$FirstName,
		$LastName,
		$email,
		password_hash($pwd . $email, '2y'),	// Hash to verify if the password is correct.
		$m_pass[0],	// encrypted_userKey
		// Data encrypted with userKey
		// ($username)?	openssl_encrypt($username,	'aes-256-cbc-hmac-sha256', $m_pass[1], 0, $m_iv) : null,
		$username, // Because username is used to login it's no longer encrypted
		$perms
	];
	if($m_vars[1] === false) return 'Encryptie mislukt; Failed to create password hash';
	if(array_search(false, $m_vars, true) !== false) return 'Encryptie mislukt; Failed to openssl encrypt data';
	$m_return = DatbQuery(null, 'INSERT INTO `site_users` (`FirstName`, `LastName`, `email`, `pwd`, `encryptedkey`, `username`, `perms`) VALUES (?, ?, ?, ?, ?, ?, ?)', 'ssssssi', ...$m_vars);
	if(is_string($m_return)) return $m_return;
	return null;
}