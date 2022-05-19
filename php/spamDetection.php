<?php
// For dealing with spam. Not implemented.
require_once __DIR__ .'/credentialFunctions.php';
function testUser(string $REMOTE_ADDR) {
	$result = DatbQuery("SELECT `attempts`, `last_attempt` FROM `FailedAutentications` WHERE `REMOTE_ADDR`=?", 's', $REMOTE_ADDR);
	if($result instanceof mysqli_result) {
		$output = $result->fetch_assoc();
		if(is_array($output)) {
			$attempts = intval($output['attempts'])+1;
			if($attempts > 10) return;
			if(round(abs(time() - strtotime($output['last_attempt'])) / 60,2) > 5) {
				$attempts = 1;
			}
			DatbQuery("UPDATE `FailedAutentications` SET `attempts`=?, `last_attempt`=CURRENT_TIMESTAMP WHERE `REMOTE_ADDR`=?", 'is', $attempts, $REMOTE_ADDR);
			return;
		}
	}
	DatbQuery("INSERT INTO `FailedAutentications` VALUES (?,1,CURRENT_TIMESTAMP)", 's', $REMOTE_ADDR);
}
function isBlocked(string $REMOTE_ADDR) {
	$result = DatbQuery("SELECT `attempts`, `last_attempt` FROM `FailedAutentications` WHERE `REMOTE_ADDR`=?", 's', $REMOTE_ADDR);
	if($result instanceof mysqli_result) {
		$output = $result->fetch_assoc();
		if(is_array($output)) {
			$attempts = intval($output['attempts']);
			if(round(abs(time() - strtotime($output['last_attempt'])) / 60,2) > 5000) {
				DatbQuery("DELETE FROM `FailedAutentications` WHERE `REMOTE_ADDR`=?", 's', $REMOTE_ADDR);
				return false;
			}
			if($attempts >= 10)
				return true;
		}
	}
	return false;
}