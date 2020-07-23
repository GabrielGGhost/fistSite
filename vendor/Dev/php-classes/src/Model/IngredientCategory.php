<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;


class IngredientCategory extends Model {

	const SESSION_ERROR = "IngredientCategorytError";
	const SESSION_SUCCESS = "IngredientCategorySuccess";
	const REGISTER_VALUES = 'IngredientCategegoryregisterValues';

	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_ingredientcategory");

		return $results;
	}

	public static function setError($msg) {

		$_SESSION[IngredientCategory::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[IngredientCategory::SESSION_ERROR])) ? $_SESSION[IngredientCategory::SESSION_ERROR] : "";
		
		IngredientCategory::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[IngredientCategory::SESSION_ERROR] = NULL;
	}
///////////////////////////////////////////////////////////////////
	public static function setSuccess($msg) {

		$_SESSION[IngredientCategory::SESSION_SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[IngredientCategory::SESSION_SUCCESS])) ? $_SESSION[IngredientCategory::SESSION_SUCCESS] : "";
		
		IngredientCategory::clearMsgSuccess();

		return $msg;
	}

	public static function clearMsgSuccess(){
		$_SESSION[IngredientCategory::SESSION_SUCCESS] = NULL;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("call sp_ingredientscategory_save(:NAME)",[
														 	':NAME'=>utf8_decode($this->getname())
														 ]);


		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public function getIngredientCategory($idCategory){

		$sql = new Sql();

		$results = $sql->select("SELECT * 
									FROM tb_ingredientcategory
										WHERE idCategory = :IDCATEGORY", [
											':IDCATEGORY'=>$idCategory
										]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);


		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_ingredientscategory_update(:IDCATEGORY,:NAME)",[
															':IDCATEGORY'=>$this->getidCategory(),
														 	':NAME'=>utf8_decode($this->getname())
														 ]);

;
		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public static function verifyIngredientCategory($name){

		$sql = new Sql();

		$name = utf8_decode($name);

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

		$sql->query("UPDATE tb_ingredientcategory
						SET active = :STATUS
							WHERE idCategory = :IDCATEGORY", [
							':STATUS'=>!$this->getactive(),
							':IDCATEGORY'=>$this->getidCategory()
						]);
	}
}


?>