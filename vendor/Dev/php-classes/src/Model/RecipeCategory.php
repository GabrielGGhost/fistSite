<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;

class RecipeCategory extends Model {

	const SESSION_ERROR = "IngredientCategorytError";
	const SESSION_SUCCESS = "IngredientCategorySuccess";
	const REGISTER_VALUES = 'registerValues';

	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_recipecategory");

		return $results;
	}

	public static function setError($msg) {

		$_SESSION[RecipeCategory::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[RecipeCategory::SESSION_ERROR])) ? $_SESSION[RecipeCategory::SESSION_ERROR] : "";
		
		RecipeCategory::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[RecipeCategory::SESSION_ERROR] = NULL;
	}
///////////////////////////////////////////////////////////////////
	public static function setSuccess($msg) {

		$_SESSION[RecipeCategory::SESSION_SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[RecipeCategory::SESSION_SUCCESS])) ? $_SESSION[RecipeCategory::SESSION_SUCCESS] : "";
		
		RecipeCategory::clearMsgSuccess();

		return $msg;
	}

	public static function clearMsgSuccess(){
		$_SESSION[RecipeCategory::SESSION_SUCCESS] = NULL;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("call sp_recipecategory_save(:NAME)",[
														 	':NAME'=>ucfirst(utf8_decode($this->getname()))
														 ]);


		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public function getRecipeCategory($idCategory){

		$sql = new Sql();

		$results = $sql->select("SELECT * 
									FROM tb_recipecategory
										WHERE idCategory = :IDCATEGORY", [
											':IDCATEGORY'=>$idCategory
										]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);


		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_recipecategory_update(:IDCATEGORY,:NAME)",[
															':IDCATEGORY'=>$this->getidCategory(),
														 	':NAME'=>utf8_decode($this->getname())
														 ]);

;
		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setData($data);
	}

	public static function verifyRecipeCategory($name){

		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_recipecategory
										WHERE name = :NAME",[
										':NAME'=>$name
									]);
	
		if (count($results) === 0) return false;

		return true;
	}




	public function des_active(){

		$sql = new Sql();

		$sql->query("UPDATE tb_recipecategory
						SET active = :STATUS
							WHERE idCategory = :IDCATEGORY", [
							':STATUS'=>!$this->getactive(),
							':IDCATEGORY'=>$this->getidCategory()
						]);
	}
}


?>