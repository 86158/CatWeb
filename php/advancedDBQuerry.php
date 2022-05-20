<?php
// Me trying to improve the wrapper. This is not used and can be ommited from the site.
/**
 * Wrapper for class mysqli.
 * @param string $query SQL query wihout terminating semicolon or \g having its Data Manipulation Language (DML) parmeters replaced with `?` and put into ...$vars
 * @param string $types A string containing a single character for each arguments passed with ...$vars depending on the type. 's' for string, 'd' for float, 'i' for int, 'b' for BLOB
 * @param string|int|float|BLOB ...$vars
 * @return mysqli_result|string|int For errors it returns a string, for successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query will return a mysqli_result object. For other successful queries mysqli_query will return the number of affected rows.
 * @see https://php.net/manual/en/class.mysqli.php Used for the actual database comminucation.
 * @throws InvalidArgumentException If $types does not match the constrants.
 */
function DatbQuery_3(mysqli $conn = null, string $query, string $types = '', ...$vars) {
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
		$error = $conn->error_list;
		if($m_close) $conn->close();
		return var_export($error, true);
	}
	// Attempt to bind parameters to their relative placeholders.
	if($types != '') {
		if(!($m_prep->bind_param($types, ...$vars))) {
			$error = $m_prep->error_list;
			$m_prep->close(); if($m_close) $conn->close();
			return var_export($error, true);
		}
	}
	// Execute the querry.
	if(!$m_prep->execute()) {
		$error = $m_prep->error_list;
		$m_prep->close(); if($m_close) $conn->close();
		return var_export($error, true);
	}
	// Get the results.
	$m_result = $m_prep->get_result();
	if($m_result == false)
		$m_result = ($m_prep->errno == 0)?
			$m_prep->affected_rows :
			var_export($m_prep->error_list, true);
	// close connection
	$m_prep->close();
	if($m_close) $conn->close();
	return $m_result;
}