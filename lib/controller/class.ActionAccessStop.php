<?php



class ActionAccessStop {


	public static function action($datas) {

		$session_id = trim($datas->session);
		if (strlen($session_id) < 5) {
			throw new Exception("NO_SESSION_ID");
		}
		$db = Db::singleton();

		$limit = "LIMIT 1";
		if (isset($datas->all) && $datas->all === true) {
			$limit = "";
		}

		$query = "update api_sessions set dteEnd=now() where session_id=".$db->quote($session_id)." AND dteEnd IS NULL order by dteStart ".$limit;
		error_log($query);
		$st = $db->prepare($query);
		if (!$st->execute()) throw new Exception('ERR_DB_SESSION');

		return "OK";
	}

	public static function needAuth() {
		return true;
	}

}