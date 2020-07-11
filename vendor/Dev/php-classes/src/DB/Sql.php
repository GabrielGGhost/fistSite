<?php 

namespace Dev\DB;

class Sql {

	const HOSTNAME = "127.0.0.1";
	const USERNAME = "root";
	const PASSWORD = "";
	const DBNAME = "db_receitas";

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"mysql:dbname=" . Sql::DBNAME .
			";host=" . Sql::HOSTNAME, 
			Sql::USERNAME,
			Sql::PASSWORD
		);

	}

	public function select($rawQuery, $params = array()):array{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function query($rawQuery, $params = array()){

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

	}

	public function setParams($stmt, $parameters = array()){

		foreach ($parameters as $key => $value) {
			$this->bindParam($stmt, $key, $value);
		}

	}

	public function bindParam($stmt, $key, $value){

		$stmt->bindParam($key, $value);
	}

}



?>