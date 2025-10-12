<?php
define("SQL", true);
include dirname(__FILE__).'/../lib/lib.php';

try {

	$dbRadius = new Db($DB_RADIUS['host'], $DB_RADIUS['port'], $DB_RADIUS['user'], $DB_RADIUS['pass'], $DB_RADIUS['db']);

	$query = "select username, callingstationid, acctstarttime, acctupdatetime,acctstoptime, acctinputoctets, acctoutputoctets, acctterminatecause from radacct where username like 'API%' order by acctstarttime asc";
	$st = $dbRadius->prepare($query);
	if (!$st->execute()) throw new Exception('ERR_DB_1');

	$res = $st->fetchAll(Db::FETCH_OBJ);

	$radSessions = array();
	foreach($res as $line) {
		$radSessions[$line->username] = $line;
	}

	$db = Db::singleton();
	$query = "SELECT * from api_sessions where dteEnd IS NULL ORDER BY dteStart ASC";
	$st = $db->prepare($query);
	if (!$st->execute()) {
		exit("ERR 2");
	}

	$res = $st->fetchAll(Db::FETCH_OBJ);

	foreach($res as $line) {

		if (!isset($radSessions[$line->username])) {
			$query = "update api_sessions set dteEnd=now() where username=".$db->quote($line->username);
			$st = $db->prepare($query);
			$st->execute();

			
			$query = "DELETE FROM radcheck WHERE username = ".$dbRadius->quote($line->username);	
				$st = $dbRadius->prepare($query);
				if (!$st->execute()) throw new Exception('ERR_DB_1');

			$query = "DELETE FROM radreply WHERE username = ".$dbRadius->quote($line->username);
				$st = $dbRadius->prepare($query);
				if (!$st->execute()) throw new Exception('ERR_DB_2');

			$query = "DELETE FROM radacct WHERE username = ".$dbRadius->quote($line->username);
				$st = $dbRadius->prepare($query);
				if (!$st->execute()) throw new Exception('ERR_DB_3');

			
			continue;
		}

		$radius = $radSessions[$line->username];

		$dte_end = null;
		if (!is_null($radius->acctstoptime)) {
			$dte_end = $radius->acctstoptime;
		}

		if ($line->bytesIn < $radius->acctinputoctets || $line->bytesOut < $radius->acctoutputoctets) {
			// Envoie du changement !
			$rx = $radius->acctoutputoctets - $line->bytesOut;
			$tx = $radius->acctinputoctets - $line->bytesIn;
			if ($line->statsUrl != '') {
				if (strpos($line->statsUrl, '?', 4) !== false) {
					$url = $line->statsUrl.= '&';
				} else $url = $line->statsUrl.'?';
				$url.= "session=".rawurlencode($line->session_id);
				$url.= "&tx=".rawurlencode($tx);
				$url.= "&rx=".rawurlencode($rx);
				$curl = curl_init($url);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					$ret = curl_exec($curl);
					echo $url."<br />\n";
			}

			$query = "update api_sessions set bytesIn=".$db->quote($radius->acctinputoctets).", bytesOut=".$db->quote($radius->acctoutputoctets)." where username=".$db->quote($line->username);
			$st = $db->prepare($query);
			$st->execute();
		}

		if ($dte_end != null ) {
			$query = "update api_sessions set dteEnd=".$db->quote($dte_end)." where username=".$db->quote($line->username);
			$st = $db->prepare($query);
			$st->execute();

			
			$query = "DELETE FROM radcheck WHERE username = ".$dbRadius->quote($line->username);	
				$st = $dbRadius->prepare($query);
				if (!$st->execute()) throw new Exception('ERR_DB_1');

			$query = "DELETE FROM radreply WHERE username = ".$dbRadius->quote($line->username);
				$st = $dbRadius->prepare($query);
				if (!$st->execute()) throw new Exception('ERR_DB_2');

				$query = "DELETE FROM radacct WHERE username = ".$dbRadius->quote($line->username);
					$st = $dbRadius->prepare($query);
					if (!$st->execute()) throw new Exception('ERR_DB_3');
		}

		unset($radSessions[$line->username]);

	}

	foreach($radSessions as $session) {
		echo "RESTE = ".$session->username."\n";
		
			
		$query = "DELETE FROM radcheck WHERE username = ".$dbRadius->quote($session->username);	
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_1');

		$query = "DELETE FROM radreply WHERE username = ".$dbRadius->quote($session->username);
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_2');

		$query = "DELETE FROM radacct WHERE username = ".$dbRadius->quote($session->username);
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_3');
	}



} catch(Exception $e) {
	exit("Exception = ".print_r($e, true));
}

