<?php

class Eleve{
	private $eleve_id;
	private $nom;
	private $email;
	private $datenaissance;
	private $emailparent;
	private $telparent;
	private $nomparent;

	function __construct($nom=null,$email=null,$datenaissance=null,$emailparent=null,$telparent=null,$nomparent=null){
		$this->eleve_id=null;
		$this->nom=$nom;
		$this->email=$email;
		$this->datenaissance=$datenaissance;
		$this->emailparent=$emailparent;
		$this->telparent=$telparent;
		$this->nomparent=$nomparent;
	}

	function __destruct(){
	}

	function getId(){
		return $this->eleve_id;
	}

	function setId($id){
		$this->eleve_id=$id;
	}

	function getNom(){
		return $this->nom;
	}

	function setNom($nom){
		$this->nom=$nom;
	}

	function getEmail(){
		return $this->email;
	}

	function setEmail($email){
		$this->email=$email;
	}

	function getDateNaissance(){
		return $this->datenaissance;
	}

	function setDateNaissance($datenaissance){
		$this->datenaissance=$datenaissance;
	}

	function getEmailParent(){
		return $this->emailparent;
	}

	function setEmailParent($emailparent){
		$this->emailparent=$emailparent;
	}

	function getTelParent(){
		return $this->telparent;
	}
	
	function setTelParent($telparent){
		$this->telparent = $telparent;
	}

	function getNomParent(){
		return $this->nomparent;
	}

	function setNomParent($nomparent){
		$this->nomparent=$nomparent;
	}

	function toJson(){
		return json_encode(Array(
			"id" => $this->getId();
			"nom" => $this->getNom();
			"email" => $this->getEmail();
			"datenaissance" => $this->getDateNaissance();
			"emailparent" => $this->getEmailParent();
			"telparent" => $this->getTelParent();
			"nomparent" => $this->getNomParent();
		));
	}

	function patchFromJson(json){
		$values = json_decode(json);
		foreach($values as $key => $value){
			switch($key){
			case "id":
				$this->setId($value);
				break;
			case "nom":
				$this->setNom($value);
				break;
			case "email":
				$this->setEmail($value);
				break;
			case "datenaissance":
				$this->setDateNaissance($value);
				break;
			case "emailparent":
				$this->setEmailParent($value);
				break;
			case "telparent":
				$this->setTelParent($value);
				break;
			case "nomparent":
				$this->setNomParent($value);
				break;
			}
		}
	}

	static function fromJson(json){
		$e = new Eleve();
		$e->patchFromJson(json);
		return $e;
	}
}
?>
