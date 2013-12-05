<?php

class bdd
{
	private static $instance;
	private $instancePDO;

	private function __construct(){
		try{
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
			$this->instancePDO = new PDO(DSN, USER, PASSWD, $options);
			$this->instancePDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}
	}
	public static function getInstance(){
		if (!isset (self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getInstancePDO(){
		return $this->instancePDO;
	}

	function __destruct(){
		$this->db = null;
	}
}

?>


