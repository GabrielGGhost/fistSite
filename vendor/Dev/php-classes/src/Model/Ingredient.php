<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;

class Ingredient extends Model {


	public function listAll(){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_ingredient");

		return $results;
	}

}


?>