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

		$results = $sql->select("call sp_measure_save(:SINGULARNAME,
														:PLURALNAME)", [
														 	':SINGULARNAME'=>strtolower(utf8_decode($this->getsingularName())),
														 	':PLURALNAME'=>strtolower(utf8_decode($this->getpluralName()))
														 ]);

		$data = $results[0];

		$data['singularName'] = utf8_encode($data['singularName']);
		$data['pluralName'] = utf8_encode($data['pluralName']);

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

		$data['singularName'] = utf8_encode($data['singularName']);
		$data['pluralName'] = utf8_encode($data['pluralName']);

		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_measure_update(:IDMEASURE,
														:SINGULARNAME,
														:PLURALNAME)",[
															':IDMEASURE'=>$this->getidType(),
														 	':SINGULARNAME'=>utf8_decode($this->getsingularName()),
														 	':PLURALNAME'=>utf8_decode($this->getpluralName())
														 ]);

;

		$data = $results[0];

		$data['singularName'] = utf8_encode($data['singularName']);
		$data['pluralName'] = utf8_encode($data['pluralName']);

		$this->setData($data);
	}

	public static function verifyMeasure($measure){

		$sql = new Sql();

		$measure = utf8_decode($measure);

		$results = $sql->select("SELECT * 
									FROM tb_measure
										WHERE singularName = :SINGULARNAME", [
											':SINGULARNAME'=>$measure
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