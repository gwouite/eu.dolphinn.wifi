<?php
define("SQL", true);
require_once __DIR__.'/../lib/lib.php';

$postedBody = file_get_contents('php://input');
if (is_null($postedBody)) {
	Response::err('NO_DATA');
}
$request = json_decode($postedBody);
if ($request === false || !is_a($request, 'stdClass') || !isset($request->action)) {
	Response::err('DATA_NOT_CORRECT');
}

$action = preg_replace('/([^a-z]+)/i','',$request->action);
if ($action == '') {
	Response::err('NO_ACTION');
}

try {

	$datas = null;
	if (isset($request->datas)) {
		$datas = $request->datas;
	}
	$class = 'Action'.$action;
	if (!class_exists($class)) {
		throw new Exception('NO_ACTION_CLASS');
	}

	$token = false;
	if (method_exists($class,'needAuth') && $class::needAuth() !== false) {
		
		$headers = getallheaders();
		if (!isset($headers['Auth-Token'])) {
			throw new Exception('AUTH_ERR', 88);
		}
		$token = $headers['Auth-Token'];
		JWT::singleton()->check($token);
		
		if ($class::needAuth() !== true) {
			$payload = JWT::singleton()->check($token);
			if ($payload->type < $class::needAuth()) {
				throw new Exception('AUTH_ERR', 55);
			}
		}
	}
	
	if (method_exists($class,'action')) {
		$ret = $class::action($datas);
	} else {
		$ret = 'OK';
	}

	Response::ok($ret, $token);

} catch (Exception $e) {
	error_log("Erreur = ".$e->getMessage().' ('.$e->getCode().')');
	Response::err($e->getMessage());
}

