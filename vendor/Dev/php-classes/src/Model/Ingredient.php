<?php 

namespace Dev\Model;

use Dev\Model;
use Dev\DB\Sql;
use \CoffeeCode\Cropper\Cropper;
use \Faker\Factory;

class Ingredient extends Model {

	const SESSION_ERROR = "IngredientError";
	const SESSION_SUCCESS = "IngredientSuccess";

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
		$_SESSION[Ingredient::SESSION_ERROR] = NULL;
	}
///////////////////////////////////////////////////////////////////
	public static function setSuccess($msg) {

		$_SESSION[Ingredient::SESSION_SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[Ingredient::SESSION_SUCCESS])) ? $_SESSION[Ingredient::SESSION_SUCCESS] : "";
		
		Ingredient::clearMsgSuccess();

		return $msg;
	}

	public static function clearMsgSuccess(){
		$_SESSION[Ingredient::SESSION_SUCCESS] = NULL;
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

	public function getValues(){

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;

	}

	public function checkPhoto() {

		if(file_exists(
			$_SERVER['DOCUMENT_ROOT'] .
			DIRECTORY_SEPARATOR .
			"res" .
			DIRECTORY_SEPARATOR .
			"site" .
			DIRECTORY_SEPARATOR .
			"img" .
			DIRECTORY_SEPARATOR .
			"igrendients_pictures" .
			DIRECTORY_SEPARATOR .
			$this->getpictureId() .
			".jpg"
		)) {

			$url = "/res/site/img/igrendients_pictures/" . $this->getpictureId() . ".jpg";
		} else {

			$url = "/res/site/img/defaults/ingredient-default.jpg";

		}

		$this->setpathPhoto($url);

		$this->resizePicture();
	}

	public function setPhoto($file){

		$this->unlinkImage();

		$extension = explode('.', $file["name"]);
		$extension = end($extension);

		switch ($extension) {
			case 'jpg':
			case 'pjpeg';
			case 'jpeg':
				$image = imagecreatefromjpeg($file["tmp_name"]);
				break;

			case 'gif':
				$image = imagecreatefromgif($file["tmp_name"]);
				break;

			case 'png':
				$image = imagecreatefrompng($file["tmp_name"]);
				break;
			default:
				throw new \Exception("Formtato de imagem não aceito!");
				header("Location: /admin/ingredients/" . $this->getidIngredient());
				exit;

		}

		$picture_name = $this->getidIngredient() . "_" . uniqid() .
						".jpg";

		$destFolder = $_SERVER['DOCUMENT_ROOT'] .
						DIRECTORY_SEPARATOR .
						"res" . 
						DIRECTORY_SEPARATOR .
						"site" .
						DIRECTORY_SEPARATOR .
						"img" .
						DIRECTORY_SEPARATOR .
						"igrendients_pictures" .
						DIRECTORY_SEPARATOR .
						$picture_name;

		imagejpeg($image, $destFolder);
		imagedestroy($image);
		$this->setpictureId($picture_name);
		$this->checkPhoto();
	}

	public function updatePictureDB($pictureId, $idIngredient = NULL){

		(isset($idIngredient)) ? $this->setidIngredient($idIngredient): $this->setidIngredient($this->getidIngredient());
		
		$sql = new Sql();

		$sql->query("UPDATE tb_ingredient
						SET pictureId = :ID
							WHERE idIngredient = :IDINGREDIENT", [
							':ID'=>$pictureId,
							':IDINGREDIENT'=>$this->getidIngredient()
						]);
	}

	public function unlinkImage(){

		$file = $_SERVER['DOCUMENT_ROOT'] .
					DIRECTORY_SEPARATOR .
					"res" . 
					DIRECTORY_SEPARATOR .
					"site" .
					DIRECTORY_SEPARATOR .
					"img" .
					DIRECTORY_SEPARATOR .
					"igrendients_pictures" .
					DIRECTORY_SEPARATOR .
					$this->getpictureId() .
					".jpg";

		if(file_exists($file)) unlink($file);
	}


	public function resizePicture(){

		$path = $_SERVER['DOCUMENT_ROOT'] .
					DIRECTORY_SEPARATOR .
					"res" .
					DIRECTORY_SEPARATOR .
					"site" .
					DIRECTORY_SEPARATOR .
					"img" .
					DIRECTORY_SEPARATOR .
					"igrendients_pictures" .
					DIRECTORY_SEPARATOR .
					$this->getpictureId();

		$dir = $_SERVER['DOCUMENT_ROOT'] .
					DIRECTORY_SEPARATOR .
					"res" .
					DIRECTORY_SEPARATOR .
					"site" .
					DIRECTORY_SEPARATOR .
					"img" .
					DIRECTORY_SEPARATOR .
					"igrendients_pictures";

		$c = new Cropper($dir);

		$c->make($path, 300, $this->getidIngredient(), "ingredients",  200);

	}
}


?>