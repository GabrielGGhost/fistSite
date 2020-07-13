<?php 

namespace Dev\Model;

use \Dev\DB\Sql;
use \Dev\Model;

class User extends Model {

	const SESSION = "User";
	const SESSION_ERROR = "UserError";

	public static function login($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_users a
										INNER JOIN tb_person b
											ON a.idPerson = b.idPerson
												WHERE a.deslogin = :LOGIN", array(
													':LOGIN'=>$login
												));
		if (count($results === 0)) {
			throw new \Exception("Usuário ou senha inválidao!");
			header("Location \admin\Login");
			exit;
		}

		$data = $results[0];

		if ($password === $data['password']) {

			$user = new User();

			$data['name'] = utf8_encode($data['name']);

			$user->setData($data);

			return $user;

		} else {
			throw new \Exception("Usuário ou senha inválidao!");
			header("Location \admin\Login");
			exit;
		}
	}

	/////////////////////////////////////////////

	public static function setError($msg) {

		$_SESSION[User::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[User::SESSION_ERROR])) ? $_SESSION[User::SESSION_ERROR] : "";
		
		User::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[User::SESSION_ERROR] = NULL;
	}
}


?>