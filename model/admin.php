<?php
require_once(ROOT."/model/bdd.php");
require_once(ROOT."/tools/key.php");

class Admin {
	private $id_admin;
	private $email;
	private $new_pw;
	private $session_key

	public function __construct($id_admin=null, $email=null){
		$this->id_admin = $id_admin;
		$this->email = $email;
	}

	function getId(){ return $this->id_admin; }
	function getEmail(){ return $this->email; }
	function setEmail($email){ $this->email = $email; }

	function setPassword($pw){ $this->new_pw = $pw; }
	function getKey(){ return $this->session_key; }
	function setKey($key){ $this->session_key = $key; }

	function update(){
		$db = bdd::getInstance()->getInstancePDO();
		$q = $db->prepare("UPDATE admin SET email=:email" + (isset($this->new_pw)?", pw_hash=PASSWORD(:pw)":"") + " WHERE id=:id;");
		$q->bindValue(":id", $this->id_admin);
		$q->bindValue(":email", $this->email);
		$q->bindValue(":pw", $this->new_pw);
		if($q->execute()) return true;
		return false;
	}

	function insert(){
		$db = bdd::getInstance()->getInstancePDO();
		$q = $db->prepare("INSERT INTO admin (email, pw_hash) VALUES (:email, PASSWORD(:pw);");
		$q->bindValue(":email", $this->email);
		$q->bindValue(":pw", $this->new_pw);
		if($q->execute()){
			$this->id_admin = $db->lastinsertid();
			return true;
		}
		return false;
	}

	public static function login($email, $pw){
		$db = bdd::getInstance()->getInstancePDO();
		$q = $db->prepare("SELECT id_admin FROM admin WHERE LOWER(email) = LOWER(:email) AND pw_hash = PASSWORD(:pw)");
		$q->bindValue(":email", $this->email);
		$q->bindValue(":pw", $this->new_pw);
		$q->execute();
		if($row = $db->fetch()){
			$admin = new Admin($row[0], $row[1]);
			$q = $db->prepare("INSERT INTO session (id_admin, `key`) VALUES (:id, :key) ON DUPLICATE KEY UPDATE `key` = :key;");
			$q->bindValue(":id", $admin->getId());
			$key = make_session_key();
			$q->bindValue(":key", $key);
			if($q->execute()){
				$admin.setKey($key);
				return $admin;
			}
			return false;
		}
		return false;
	}

	public function logout(){
		$db = bdd::getInstance()->getInstancePDO();
		$q = $db->prepare("DELETE FROM session WHERE id_admin = :id");
		$q->bindValue(":id", $self->getId());
		$q->execute();
	}

	public static function find($id=null, $sesskey=null){
		$db = bdd::getInstance()->getInstancePDO();
		if(!$id && !$sesskey){
			return false;
		}
		elseif($sesskey){
			$q = $db->prepare("SELECT admin.id_admin, admin.email FROM admin NATURAL JOIN session WHERE session.key = :key");
			$q->bindValue(":key", $sesskey);
		}
		else{
			$q = $db->prepare("SELECT id_admin, email FROM admin WHERE id_admin = :id");
			$q->bindValue(":id", $id);
		}
		$q->execute();
		if($row = $q->fetch())
			return new Admin($row[0], $row[1]);
		return false;
	}
	public static function findAll(){
		$db = bdd::getInstance()->getInstancePDO();
		$q = $db->prepare("SELECT id_admin, email FROM admin");
		$q->execute();
		$admins = Array();
		while($row = $q->fetch())
			array_push($admins, new Admin($row[0], $row[1]));
		return $admins;
	}
}
?>
