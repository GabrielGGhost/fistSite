<?php 

namespace Dev\Model;

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\Mailer;

class User extends Model {

	const SESSION = "User";
	const SESSION_ERROR = "UserError";
	const SECRET = "fsencoding";
	const SECRET_IV = "fsencoding_IV";

	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT idUser, name, surname, name, email, login, inadmin 
									FROM tb_users u
										INNER JOIN tb_person p
											ON p.idPerson = u.idPerson");
	}

	public static function logout() {

		$_SESSION[User::SESSION] = NULL;
	}

	public static function verifyLogin($inadmin = true){

		if(!User::checkLogin($inadmin)) {

			if($inadmin) {
				header("Location: /admin/login");
			} else {
				header("Location: /login");
			}
			exit;
		}
	}

	public static function checkLogin($inadmin = true){

		if(
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]['idUser'] > 0
		) {
			return false;
		} else {

			if($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true){

				return true;
			} else if ($inadmin === false) {

				return false;
			}
		} 
	}

	public static function login($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_users a
										INNER JOIN tb_person b
											ON a.idPerson = b.idPerson
												WHERE a.login = :LOGIN", array(
													':LOGIN'=>$login
												));



		if (count($results) === 0) {
			throw new \Exception("Usuário ou senha inválidos!");
			header("Location \admin\Login");
			exit;
		}

		$data = $results[0];

		if (password_verify($password, $data['password'])) {

			$user = new User();

			$data['name'] = utf8_encode($data['name']);

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {
			throw new \Exception("Usuário ou senha inválidao!");
			header("Location \admin\Login");
			exit;
		}
	}

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

	public function verifyEmail($email) {

		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_person
										WHERE email = :EMAIL", [
											':EMAIL'=>$email
										]);

		return (count($results) > 0);
	}

	public function save() {

		$sql = new Sql();

		$results = $sql->select("CALL sp_users_save(:NAME,
													:SURNAME,
													:LOGIN,
													:PASSWORD,
													:PHONE,
													:EMAIL,
													:INADMIN)", [
														':NAME'=>utf8_decode($this->getname()),
														':SURNAME'=>utf8_decode($this->getsurname()),
														':LOGIN'=>utf8_decode($this->getlogin()),
														':PASSWORD'=>utf8_decode($this->getpassword()),
														':PHONE'=>utf8_decode($this->getphone()),
														':EMAIL'=>utf8_decode($this->getemail()),
														':INADMIN'=>$this->getinadmin()
													]);


		$this->setData($results[0]);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_users_update(:IDUSER,
													  :NAME,
													  :SURNAME,
													  :LOGIN,
													  :PHONE,
													  :EMAIL)", [
														':IDUSER'=>$this->getidUser(),
														':NAME'=>utf8_decode($this->getname()),
														':SURNAME'=>utf8_decode($this->getsurname()),
														':LOGIN'=>utf8_decode($this->getlogin()),
														':PHONE'=>utf8_decode($this->getphone()),
														':EMAIL'=>utf8_decode($this->getemail())
													]);


		$this->setData($results[0]);
	}

	public static function getPasswordHash($password)
	{
		return password_hash($password, PASSWORD_DEFAULT, [
			'cost'=>12
		]);
	}


	public function getUser($idUser) {

		$sql = new Sql();

		$results = $sql->select("SELECT idUser, name, surname, phone, email, login, inadmin 
									FROM tb_users u
										INNER JOIN tb_person p
											ON p.idPerson = u.idPerson
												WHERE u.idUser = :IDUSER", [
													':IDUSER'=>$idUser]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);
		$data['surname'] = utf8_encode($data['surname']);
		$data['login'] = utf8_encode($data['login']);

		$this->setData($data);
	}

	public function compareEmail(){

	}

	public static function getForgot($email, $inadmin = true) {
		
		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_person a
										INNER JOIN tb_users
												USING(idPerson)
													WHERE a.email = :EMAIL", [
														':EMAIL'=>$email
													]);


		if(count($results) === 0) {
			throw new \Exception("Não foi possível recuperar a senha!");
			
		} else {

			$data = $results[0];

			$results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:IDUSER, :DESIP)", [
				':IDUSER'=>$data['idUser'],
				':DESIP'=>$_SERVER['REMOTE_ADDR']
			]);
		}

		if(count($results2) === 0) {

			throw new Exception("Não foi possível recuperar a senha!");
			
		} else {

			$dataRecovery = $results2[0];

			$code = openssl_encrypt($dataRecovery['idRecovery'],
									 'AES-128-CBC',
									  pack('a16',
									  USER::SECRET),
									  0,
									  pack('a16', User::SECRET_IV));

			$code = base64_encode($code);

			if ($inadmin) {

				$link = "http://www.firstSite.com.br/admin/forgot/reset?code=$code";
			} else {
				$link = "http://www.firstSite.com.br/forgot/reset?code=$code";
			}

			$mailer = new Mailer($data['email'],
								$data['name'],
								"Redefinir senha de first site",
								"forgot", array(
									'name'=>$data['name'],
									'link'=>$link
								));

			$mailer->send();

			return $link;
		}
	}

	public static function validForgotDescrypt($code){

		$code = base64_decode($code);


		$idrecovery = openssl_decrypt($code,
										'AES-128-CBC',
										pack("a16", User::SECRET),
										0,
										pack("a16", User::SECRET_IV)
										);

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
				FROM tb_userspasswordrecovery a
					INNER JOIN tb_users b
						USING(idUser)
					INNER JOIN tb_person c
						USING(idPerson)
							WHERE a.idrecovery = :IDRECOVERY
								AND a.dtRecovery IS NULL
								AND DATE_ADD(a.dtRegister, INTERVAL 1 HOUR) >= NOW()", array(
									":IDRECOVERY"=>$idrecovery
							));

		if(count($results) === 0){
			throw new \Exception("Não foi possível recuperar a senha!");
		}else{

			return $results[0];
		}
	}

	public static function setForgotUsed($idRecovery){

		$sql = new Sql();

		$sql->query("
			UPDATE tb_userspasswordrecovery
				SET dtRecovery = NOW()
					WHERE idRecovery = :idRecovery", array(
						"idRecovery"=>$idRecovery
					));

	}

	public function get($idUser){
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_person b USING(idPerson) WHERE a.iduser = :iduser", array(
			":iduser"=>$idUser
		));

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);

	}

	public function updatePassword($password){

		$sql = new Sql();

		$sql->query("
			UPDATE tb_users
				SET password = :PASSWORD
					WHERE idUser = :IDUSER", [
						':PASSWORD'=>$password,
						':IDUSER'=>$this->getidUser()
					]);


	}
}


?>