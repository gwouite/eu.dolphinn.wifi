<?php



class ActionAccessCreate {


	public static function action($datas) {
		global $DB_RADIUS;


		$limit_tx = 256;
		$limit_rx = 256;
		$port_limit = 1;

		$limited = false;

		if (!is_a($datas, "stdClass")) {
			throw new Exception("NO_DATAS");
		}
		if (!isset($datas->session) || strlen($datas->session) < 5) {
			throw new Exception("NO_SESSION_ID");
		}
		if (!isset($datas->validUntil)) {
			throw new Exception("NO_VALIDITY_LIMIT");
		}

		if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/', $datas->validUntil, $regs)) {
			$limit = $regs[1].'-'.$regs[2].'-'.$regs[3].'T'.$regs[4].':'.$regs[5].':'.$regs[6].'+00:00';
		} else
		if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})$/', $datas->validUntil, $regs)) {
			$limit = $regs[1].'-'.$regs[2].'-'.$regs[3].'T'.$regs[4].':'.$regs[5].':00+00:00';
		} else {
			throw new Exception("INVALID_VALIDITY_LIMIT");
		}

		// $limit = min($limit, time() + 86400*3);  // Max = 3 jours

		if (isset($datas->limits) && is_a($datas->limits, 'stdClass')) {
			if (isset($datas->limits->tx)) {
				$limit_tx = max($limit_tx, (int)$datas->limits->tx);
			}
			if (isset($datas->limits->rx)) {
				$limit_rx = max($limit_rx, (int)$datas->limits->rx);
			}
			if (isset($datas->limits->devices)) {
				$port_limit = max($port_limit, (int)$datas->limits->devices);
			}
			if (isset($datas->limits->type) && $datas->limits->type == 'limited') {
				$limited = true;
			}
		}

		$urlStats = '';
		if (isset($datas->ackStatsSession) && filter_var(trim($datas->ackStatsSession), FILTER_VALIDATE_URL)) {
			$urlStats = trim($datas->ackStatsSession);
		}

		// Création du login / pass !
		$logInfo = new stdClass();
		$logInfo->username = 'API-'.gen_uuid();
		$logInfo->password = gen_uuid();

		$db = Db::singleton();

		// Vérification port-limit !
		$query = "SELECT count(*) as nb from api_sessions where session_id = ".$db->quote($datas->session)." AND dteEnd IS NULL";
		$st = $db->prepare($query);
		if (!$st->execute()) {
			error_log(print_r($db->errorInfo(), true).print_r($db, true));
			throw new Exception('ERR_DB_SESSION_1');
		}
		$res = $st->fetchAll(Db::FETCH_OBJ);
		if (count($res) != 1) throw new Exception('ERR_DB_SESSION_2');
		if ($res[0]->nb >= $port_limit) {
			throw new Exception('ERR_DEVICE_LIMIT');
		}

		$query = "INSERT INTO api_sessions (username, session_id, statsUrl) VALUES (".$db->quote($logInfo->username).", ".$db->quote($datas->session).", ".$db->quote($urlStats).")";
		$st = $db->prepare($query);
		if (!$st->execute()) throw new Exception('ERR_DB_SESSION_3');
		
		$dbRadius = new Db($DB_RADIUS['host'], $DB_RADIUS['port'], $DB_RADIUS['user'], $DB_RADIUS['pass'], $DB_RADIUS['db']);

		$query = "DELETE FROM radcheck WHERE username = ".$dbRadius->quote($logInfo->username);	
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_1');

		$query = "DELETE FROM radreply WHERE username = ".$dbRadius->quote($logInfo->username);
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_2');

		$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($logInfo->username).",'Mikrotik-Rate-Limit',':=','".$limit_rx."k/".$limit_tx."k')";
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_3');
			
		$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($logInfo->username).",'WISPr-Session-Terminate-Time',':=','".$limit."')";
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_4');
		
		if($limited) {
			$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($logInfo->username).",'Mikrotik-Mark-Id',':=','HSLimited.in')";
				$st = $dbRadius->prepare($query);
				if (!$st->execute()) throw new Exception('ERR_DB_4');
		}
		$query = "INSERT INTO radreply (username, attribute, op, `value`) VALUES (".$dbRadius->quote($logInfo->username).",'Port-Limit',':=','1')";
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_5');

		$query = "INSERT INTO radcheck (username, attribute, op, `value`) VALUES (".$dbRadius->quote($logInfo->username).",'Cleartext-Password',':=',".$dbRadius->quote($logInfo->password).")";
			$st = $dbRadius->prepare($query);
			if (!$st->execute()) throw new Exception('ERR_DB_6');


		return $logInfo;
	}

	public static function needAuth() {
		return true;
	}

}