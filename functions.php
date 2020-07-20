<?php 

use Dev\Model\User;



function encodeData($data){

	foreach ($data as $key => &$value) {

		foreach ($value as $key => &$value) {

			$value = utf8_encode($value);
		}
	}

	return $data;
}

?>