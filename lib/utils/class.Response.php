<?php

class Response {
    
	private static function setHeaders() {
		if (!headers_sent()) {
			header("Content-Type: application/json");
			header("Pragma: No-Cache");
		}
	}

	public static function err($message, $token = false) {
		$datas = array("status"=>"KO", "reason"=>$message);
		if ($token !== false) {
			$datas['token'] = $token;
		}
		self::setHeaders();
		exit(json_encode($datas, JSON_PRETTY_PRINT));
	}

	public static function ok($datas, $token = false) {
		$datas = array("status"=>"OK", "datas"=>$datas);
		if ($token !== false) {
			$datas['token'] = $token;
		}
		self::setHeaders();
		exit(json_encode($datas, JSON_PRETTY_PRINT));
	}

}