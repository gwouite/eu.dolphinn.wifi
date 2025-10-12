<?php
/**
 * Génération de JSON Web Token
 * 
 * @author Gwouite - dev@gwouite.fr
 * @copyright Guillaume MARTIN
 */
class JWT {

	private static function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
	  
	private static function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

	private static $objet = null;
    public static function singleton($key = false) {
        if (!is_null(self::$objet) && is_a(self::$objet, 'JWT')) return self::$objet;
        
		if ($key === false) {
			throw new Exception("NO_KEY", 1001);
		}

        $objet = new JWT($key);
        self::$objet = $objet;

        return self::$objet;
    }

	private $key = null;
	/**
	 * Constructeur
	 * @var $key string Clé secrète
	 */
	private function __construct($key) {
		$this->key = $key;
	}

	/**
	 * Crée le JWT
	 * 
	 * Dans le payload :
	 * 				_vd = Valid Duration
	 * 				_vu = Valid Until
	 * 
	 * @var $payload stdClass
	 * @var $time int optionnal
	 * @return string
	 */
	public function create($payload, $time = false) {

		$header = (object)[
			"alg"=>"HS256",
			"typ"=>"JWT"
		];

		if (!is_a($payload,"stdClass")){
			throw new Exception("NO_PAYLOAD", 2001);
		}

		if ($time !== false && (int) $time > 0) {
			$payload->_vd = (int)$time;
		}

		if (isset($payload->_vd)) {
			$payload->_vu = time() + $payload->_vd;
		} else {
			throw new Exception("NO_VALID_DURATION", 2002);
		}

		$_payload = json_encode($payload);
		if ($_payload === false) {
			throw new Exception("PAYLOAD_PROBLEM", 2003);
		}

		$token = self::base64url_encode(json_encode($header)).'.'.self::base64url_encode($_payload);
		$validKey = hash_hmac("sha256",$token,$this->key);
		if ($validKey === false || strlen($validKey) < 10) {
			throw new Exception("PAYLOAD_KEY_PROBLEM", 2004);
		}

		return $token.'.'.$validKey;
	}

	/**
	 * Vérifie le token et retourne le payload
	 * @var $token string
	 * @return stdClass
	 */
	public function check($token = false) {

		// Récupère le token dans "Auth-Token" ou "_token" si demandé !
		if ($token == 'header' || $token === false) {
			$headers = getallheaders();
			if (!isset($headers['Auth-Token'])) {
				if (isset($_REQUEST['_token'])) {
					$token = trim($_REQUEST['_token']);
				} else {
					throw new Exception('ERR.tokenEmpty');
				}
			} else {
				$token = $headers['Auth-Token'];
			}
		}

		$_token = explode('.',$token);
		if (count($_token) != 3) throw new Exception("TOKEN_INVALID", 3001);

		$validKey = hash_hmac("sha256",$_token[0].'.'.$_token[1],$this->key);
		if ($validKey != $_token[2]) throw new Exception("TOKEN_INVALID", 3002);

		$_payload = self::base64url_decode($_token[1]);
		$payload = json_decode($_payload);
		if ($payload === false) throw new Exception("TOKEN_INVALID", 3003);
		if (!isset($payload->_vu) || $payload->_vu < time()) {
			throw new Exception("TOKEN_EXPIRED", 3004);
		}
		return $payload;
	}
}

/**
 * the end
 */