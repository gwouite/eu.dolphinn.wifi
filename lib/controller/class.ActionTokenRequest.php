<?php



class ActionTokenRequest {


	public static function action($datas) {
		
		if ($datas->user != 'admin' || $datas->pass != 'Victori@28') {
			throw new Exception("ERR_AUTH");
		}

		$payload = new stdClass();
		$payload->valid = true;

		$token = JWT::singleton()->create($payload, (10*365*86400));
		return $token;
	}

	public static function needAuth() {
		return false;
	}

}