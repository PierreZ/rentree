<?php

class eleve{
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

	function SetDateNaissance($datenaissance){
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
		return $this->telparent;
	}

	function getNomParent(){
		return $this->nomparent;
	}

	function setNomParent($nomparent){
		$this->nomparent=$nomparent;
	}
}

?>
