<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;


class Difficult extends Model {

	const SESSION_ERROR = "DifficultError";
	const SESSION_SUCCESS = "DifficultSuccess";
	const REGISTER_VALUES = 'registerValues';

	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_difficult");

		return $results;
	}

	public static function setError($msg) {

		$_SESSION[Difficult::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[Difficult::SESSION_ERROR])) ? $_SESSION[Difficult::SESSION_ERROR] : "";
		
		Difficult::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[Difficult::SESSION_ERROR] = NULL;
	}
///////////////////////////////////////////////////////////////////
	public static function setSuccess($msg) {

		$_SESSION[Difficult::SESSION_SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[Difficult::SESSION_SUCCESS])) ? $_SESSION[Difficult::SESSION_SUCCESS] : "";
		
		Difficult::clearMsgSuccess();

		return $msg;
	}

	public static function clearMsgSuccess(){
		$_SESSION[Difficult::SESSION_SUCCESS] = NULL;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("call sp_difficult_save(:LEVEL)",[
														 	':LEVEL'=>utf8_decode($this->getdifficultLevel())
														 ]);


		$data = $results[0];

		$data['difficultLevel'] = utf8_encode($data['difficultLevel']);

		$this->setData($data);
	}

	public function getDifficultLevel($idDifficult){

		$sql = new Sql();

		$results = $sql->select("SELECT * 
									FROM tb_difficult
										WHERE idDifficult = :IDDIFFICULT", [
											':IDDIFFICULT'=>$idDifficult
										]);

		$data = $results[0];

		$data['difficultLevel'] = utf8_encode($data['difficultLevel']);


		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_difficult_update(:IDDIFFICULT,:DIFFICULTLEVEL)",[
															':IDCATEGORY'=>$this->getidCategory(),
														 	':DIFFICULTLEVEL'=>utf8_decode($this->getname())
														 ]);

;
		$data = $results[0];

		$data['difficultLevel'] = utf8_encode($data['difficultLevel']);

		$this->setData($data);
	}

	public static function verifyDifficult($name){

		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_ingredientcategory
										WHERE name = :NAME",[
										':NAME'=>$name
									]);
	
		if (count($results) === 0) return false;

		return true;
	}




	public function des_active(){

		$sql = new Sql();

		$sql->query("UPDATE tb_difficult
						SET active = :STATUS
							WHERE idDifficult = :IDCATEGORY", [
							':STATUS'=>!$this->getactive(),
							':IDCATEGORY'=>$this->getidCategory()
						]);
	}
}


?>