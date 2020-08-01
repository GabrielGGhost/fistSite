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

<!-- 
<script type="text/javascript">

var autor = getElementById('idAuthor');

autor.addEventListener('click', function(){
	alert('a');
});

</script> -->