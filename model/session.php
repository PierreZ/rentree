<?php

class Session implements JsonSerializable{
	private $is_admin;
	private $email;
	private $password;
	private $id_admin;
	private $id_eleve;
	private $key = "";

	function __construct($email, $pw=""){
		$this->email = $email;
		$this->password = $pw;
	}

	function logIn(){
		$db = bdd::getInstance()->getInstancePDO();

		$q = $db->prepare("SELECT id_admin FROM admin WHERE email = :email AND pw_hash = PASSWORD(:pw)");
		$q->bindValue(':email', $this->email);
		$q->bindValue(':pw', $this->password);
		if(!$q->execute()) return null;
		elseif($row = $q->fetch()){
			$this->is_admin = true;
			$this->id_admin = $row[0];
			$q = $db->prepare("UPDATE admin SET session_key = :key WHERE id_admin = :id");
			$q->bindValue(':id', $this->id_admin);
			$key = make_session_key();
			$q->bindValue(':key', $key);
			if(!$q->execute()) return null;
			$this->key = $key;
			return true;
		}
		elseif($this->password === PASS_ELEVE){
			$this->is_admin = false;
			$e = Eleve::find($this->email);
			if($e)
				$this->id_eleve = $e->getId();
			else // it will be created later when the user fills the form
				$this->id_eleve = 0;
			return true;
		}
		else return false;
	}

	static function fromKey($key){
		$db = bdd::getInstance()->getInstancePDO();

		$q = $db->prepare("SELECT id_admin, email FROM admin WHERE session_key = :key");
		$q->bindValue(':key', $key);
		if(!$q->execute() || !($row = $q->fetch()) ) return null;
		$sess = new Session($row[1]);
		$sess->id_admin = $row[0];
		$sess->is_admin = true;
		$sess->key = $key;

		return $sess;
	}

	function getId(){
		return $this->is_admin? $this->id_admin : $this->id_eleve;
	}

	function getKey(){
		return $this->key;
	}

	function getEmail(){
		return $this->email;
	}

	function isAdmin(){
		return $this->is_admin;
	}

	function jsonSerialize(){
		if($this->isAdmin())
			return Array(
				"is_admin" => true,
				"id_admin" => $this->getId(),
				"email" => $this->getEmail(),
				"key" => $this->getKey()
			);
		else
			return Array(
				"is_admin" => false,
				"id_eleve" => $this->getId(),
				"email" => $this->getEmail()
			);
	}

}
?>
