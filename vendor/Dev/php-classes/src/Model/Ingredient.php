<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;

class Ingredient extends Model {

	const SESSION_ERROR = "UserError";

	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_ingredient");

		return $results;
	}

	public static function setError($msg) {

		$_SESSION[Ingredient::SESSION_ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[Ingredient::SESSION_ERROR])) ? $_SESSION[Ingredient::SESSION_ERROR] : "";
		
		Ingredient::clearMsgError();

		return $msg;
	}

	public static function clearMsgError(){
		$_SESSION[User::SESSION_ERROR] = NULL;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("call sp_ingredients_save(:NAME, :DESCRIPTION)",[
														 	':NAME'=>utf8_decode($this->getname()),
														 	':DESCRIPTION'=>utf8_decode($this->getdescription())
														 ]);


		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);
		$data['description'] = utf8_encode($data['description']);

		$this->setData($data);
	}

	public function getIngredient($idIngredient){

		$sql = new Sql();

		$results = $sql->select("SELECT * 
									FROM tb_ingredient
										WHERE idIngredient = :IDINGREDIENT", [
											':IDINGREDIENT'=>$idIngredient
										]);

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);
		$data['description'] = utf8_encode($data['description']);

		$this->setData($data);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("call sp_ingredients_update(:IDINGREDIENT, :NAME, :DESCRIPTION)",[
															':IDINGREDIENT'=>$this->getidIngredient(),
														 	':NAME'=>utf8_decode($this->getname()),
														 	':DESCRIPTION'=>utf8_decode($this->getdescription())
														 ]);


		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);
		$data['description'] = utf8_encode($data['description']);

		$this->setData($data);
	}

	public function verifyIngredient($name){

		$sql = new Sql();

		$results = $sql->select("SELECT *
									FROM tb_ingredient
										WHERE name = :NAME",[
										':NAME'=>$name
									]);

		if (count($results) === 0) return false;

		return true;
	}

	public function des_active(){

		$sql = new Sql();

		$sql->query("UPDATE tb_ingredient
						SET active = :STATUS
							WHERE idIngredient = :IDINGREDIENT", [
							':STATUS'=>!$this->getactive(),
							':IDINGREDIENT'=>$this->getidIngredient()
						]);
	}
}


?>