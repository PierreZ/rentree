<?php
include_once "$root/model/bdd.php";

abstract class dao {
	public $database;  
	
	public function __construct(){
		$this->database = bdd::getInstance()->getInstancePDO();
	}  
	
	abstract function find($id);
	abstract function insert(&$objet);
	abstract function update(&$objet);
	abstract function delete(&$objet);
	      
}
?>
