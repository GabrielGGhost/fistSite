<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;


class Measure extends Model {

	const SESSION_ERROR = "MeasureError";
	const SESSION_SUCCESS = "MeasureSuccess";
	const REGISTER_VALUES = 'MeasureRegisterValues';

	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_measure");

		return $results;
	}

	public static function setError($msg) {

		$_SESSION[Measure::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[Measure::SESSION_ERROR])) ? $_SESSION[Measure::SESSION_ERROR] : "";
		
		Measure::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[Measure::SESSION_ERROR] = NULL;
	}
///////////////////////////////////////////////////////////////////
	public static function setSuccess($msg) {

		$_SESSION[Measure::SESSION_SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[Measure::SESSION_SUCCESS])) ? $_SESSION[Measure::SESSION_SUCCESS] : "";
		
		Measure::clearMsgSuccess();

		return $msg;
	}

	public static function clearMsgSuccess(){
		$_SESSION[Measure::SESSION_SUCCESS] = NULL;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("call sp_measure_save(:NAME)", [
														 	':NAME'=>strtolower(utf8_decode($this->getname()))
														 ]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public function getMeasure($idMeasure){

		$sql = new Sql();

		$results = $sql->select("SELECT * 
									FROM tb_measure
										WHERE idType = :IDMEASURE", [
											':IDMEASURE'=>$idMeasure
										]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);


		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_measure_update(:IDMEASURE,:NAME)",[
															':IDMEASURE'=>$this->getidType(),
														 	':NAME'=>utf8_decode($this->getname())
														 ]);

;

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public static function verifyMeasure($level){

		$sql = new Sql();

		$level = utf8_decode($level);

		$results = $sql->select("SELECT * 
									FROM tb_measure
										WHERE name = :NAME", [
											':NAME'=>$level
										]);

		if (count($results) === 0) return false;

		return true;
	}




	public function des_active(){

		$sql = new Sql();

		$sql->query("UPDATE tb_measure
						SET active = :STATUS
							WHERE idType = :IDMEASURE", [
							':STATUS'=>!$this->getactive(),
							':IDMEASURE'=>$this->getidType()
						]);
	}
}


?>