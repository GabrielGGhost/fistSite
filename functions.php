<?php 

use Dev\Model\User;



function encodeData($users){

	foreach ($users as $key => &$value) {

		foreach ($value as $key => &$value) {

			$value = utf8_encode($value);
		}
	}

	return $users;
}

?>