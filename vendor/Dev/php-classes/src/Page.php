<?php 

namespace Dev;

use Rain\Tpl;

class Page {

	private $tpl;
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		'data'=>[]];
	private $options = [];

	public function __construct($options = array(),$tpl_dir = "/views/"){

		$this->options = array_merge($this->defaults, $options);

		$config = array(
		    "base_url"      => null,
		    "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']. $tpl_dir,
		    "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
		    "debug"         => false
		);

		Tpl::configure( $config );

		$this->tpl = new Tpl();

		$this->setData($this->options["data"]);

		if($this->options["header"]) {

			$this->tpl->draw("header");

		}
	}

	public function __destruct(){

		$this->tpl->draw("footer");
	}

	public function setTpl($name, $data = array(), $returnHTML = false){

		$this->setData($data);

		return	$this->tpl->draw($name, $returnHTML);
	}

	public function setData($data = array()){

			foreach ($this->options["data"] as $key => $value) {
			$this->tpl->assign($key, $value);
		}
	}

}

?>