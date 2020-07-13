<?php 

namespace Dev;

use Rain\Tpl;

class Mailer {

	const USERNAME = ;
	const PASSWORD = ;
	const NAME_FROM = ;

	private $email;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array()){

		$config = array(
		    "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']. "/views/email/",
		    "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
		    "debug"         => false
		);
		Tpl::configure( $config );

		$tpl = new Tpl();

	}
}


?>