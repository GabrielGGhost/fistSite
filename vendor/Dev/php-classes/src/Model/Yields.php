<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;


class Yields extends Model {

	const SESSION_ERROR = "YieldError";
	const SESSION_SUCCESS = "YieldSuccess";
	const REGISTER_VALUES = 'yieldRegisterValues';

	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_yieldType");

		return $results;
	}

	public static function setError($msg) {

		$_SESSION[Yields::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[Yields::SESSION_ERROR])) ? $_SESSION[Yields::SESSION_ERROR] : "";
		
		Yields::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[Yields::SESSION_ERROR] = NULL;
	}
///////////////////////////////////////////////////////////////////
	public static function setSuccess($msg) {

		$_SESSION[Yields::SESSION_SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[Yields::SESSION_SUCCESS])) ? $_SESSION[Yields::SESSION_SUCCESS] : "";
		
		Yields::clearMsgSuccess();

		return $msg;
	}

	public static function clearMsgSuccess(){
		$_SESSION[Yields::SESSION_SUCCESS] = NULL;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("call sp_yeldType_save(:SINGULARNAME,
														:PLURALNAME)", [
														 	':SINGULARNAME'=>utf8_decode($this->getsingularName()),
														 	':PLURALNAME'=>utf8_decode($this->getspluralName()),
														 ]);

		$data = $results[0];

		$data['singularName'] = utf8_encode($data['singularName']);
		$data['pluralName'] = utf8_encode($data['pluralName']);

		$this->setData($data);
	}

	public function getYield($idMeasure){

		$sql = new Sql();

		$results = $sql->select("SELECT * 
									FROM tb_yieldType
										WHERE idType = :IDMEASURE", [
											':IDMEASURE'=>$idMeasure
										]);

		$data = $results[0];

		$data['singularName'] = utf8_encode($data['singularName']);
		$data['pluralName'] = utf8_encode($data['pluralName']);

		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_yieldType_update(:IDTYPE,:SINGULARNAME,
														:PLURALNAME)", [
															':IDTYPE'=>$this->getidType(),
														 	':SINGULARNAME'=>utf8_decode($this->getsingularName()),
														 	':PLURALNAME'=>utf8_decode($this->getspluralName()),
														 ]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public static function verifySingularYield($name){

		$sql = new Sql();

		$name = utf8_decode($name);

		$results = $sql->select("SELECT * 
									FROM tb_yieldType
										WHERE singularName = :NAME", [
											':NAME'=>$name
										]);

		if (count($results) === 0) return false;

		return true;
	}

	public static function verifyPluralYield($name){

		$sql = new Sql();

		$name = utf8_decode($name);

		$results = $sql->select("SELECT * 
									FROM tb_yieldType
										WHERE pluralName = :NAME", [
											':NAME'=>$name
										]);

		if (count($results) === 0) return false;

		return true;
	}


	public function des_active(){

		$sql = new Sql();

		$sql->query("UPDATE tb_yieldType
						SET active = :STATUS
							WHERE idType = :IDMEASURE", [
							':STATUS'=>!$this->getactive(),
							':IDMEASURE'=>$this->getidType()
						]);
	}
}


?>