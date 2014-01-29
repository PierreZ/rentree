<?php
require_once(ROOT."/model/bdd.php");

class Eleve implements JsonSerializable{
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

	function jsonSerialize(){
		return Array(
			"id" => $this->getId(),
			"nom" => $this->getNom(),
			"email" => $this->getEmail(),
			"datenaissance" => $this->getDateNaissance(),
			"emailparent" => $this->getEmailParent(),
			"telparent" => $this->getTelParent(),
			"nomparent" => $this->getNomParent(),
			"session_key" => hash("sha256", $this->getId() . SECRET)
		);
	}

	function patch($arr){
		foreach($arr as $key => $value){
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

	function patchFromJson($json){
		$arr = json_decode($json);
		$this->patch($arr);
	}

	static function fromJson($json){
		$e = new Eleve();
		$e->patchFromJson($json);
		return $e;
	}

	static function find($id=null){
		$database = bdd::getInstance()->getInstancePDO();
		if(is_int($id)){
			// ID is an int type
			$query  = "SELECT * FROM eleve WHERE id_eleve = :id;";
			$prepared_query = $database->prepare($query);
			$prepared_query->bindParam(':id', $id);

		}else{
			//ID represent an email here
			$query  = "SELECT * FROM eleve WHERE email = :email;";
			$prepared_query = $database->prepare($query);
			$prepared_query->bindParam(':email', $id);
		}		
		if (($prepared_query->execute())&&($prepared_query->rowCount()>0)){
			$resultat = $prepared_query->fetch(PDO::FETCH_ASSOC);

			$nom = $resultat['nom'];
			$email = $resultat['email'];
			$datenaissance = $resultat['datenaissance'];
			$emailparent = $resultat['emailparent'];
			$telparent = $resultat['telparent'];
			$nomparent = $resultat['nomparent'];
			$id = $resultat['id_eleve'];

			$eleve = new Eleve($nom,$email,$datenaissance,$emailparent,$telparent,$nomparent);
			$eleve->setId($id);
			return $eleve;
		}
		else return false;
	}

	static function findAll(){
		$database = bdd::getInstance()->getInstancePDO();

		$prepared_query = $database->prepare("SELECT * FROM eleve");
		if ($prepared_query->execute()){
			$eleves = Array();
			while($row = $prepared_query->fetch()){
				$nom = $row['nom'];
				$email = $row['email'];
				$datenaissance = $row['datenaissance'];
				$emailparent = $row['emailparent'];
				$telparent = $row['telparent'];
				$nomparent = $row['nomparent'];
				$id = $row['id_eleve'];
				
				$eleve = new Eleve($nom,$email,$datenaissance,$emailparent,$telparent,$nomparent);
				$eleve->setId($id);
				
				array_push($eleves,$eleve);
			}
			return $eleves;
		}
		else return false;
	}


	function insert(){
		$database = bdd::getInstance()->getInstancePDO();

		$nom = $this->getNom();
		$email = $this->getEmail();
		$datenaissance =$this->getDateNaissance();
		$emailparent = $this->getEmailParent();
		$telparent = $this->getTelParent();
		$nomparent = $this->getNomParent();
		$query  = "INSERT INTO eleve (email, nom, datenaissance, emailparent, telparent, nomparent) VALUES (:email,:nom,:datenaissance,:emailparent, :telparent, :nomparent);";

		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':email', $email);
		$prepared_query->bindParam(':nom', $nom);
		$prepared_query->bindParam(':datenaissance', $datenaissance);
		$prepared_query->bindParam(':emailparent', $emailparent);
		$prepared_query->bindParam(':telparent', $telparent);
		$prepared_query->bindParam(':nomparent', $nomparent);
		if ($prepared_query->execute()){
			$this->setId($database->lastinsertid());
			return true;
		}
		else return false;
	}

	function update(){
		$database = bdd::getInstance()->getInstancePDO();

		$id = $this->getId();
		$nom = $this->getNom();
		$email = $this->getEmail();
		$datenaissance =$this->getDateNaissance();
		$emailparent = $this->getEmailParent();
		$telparent = $this->getTelParent();
		$nomparent = $this->getNomParent();
		$query  = "UPDATE eleve SET nom=:nom, email=:email, datenaissance=:datenaissance, emailparent=:emailparent, telparent=:telparent,nomparent=:nomparent WHERE id_eleve = :id;";
		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':email', $email);
		$prepared_query->bindParam(':nom', $nom);
		$prepared_query->bindParam(':datenaissance', $datenaissance);
		$prepared_query->bindParam(':emailparent', $emailparent);
		$prepared_query->bindParam(':telparent', $telparent);
		$prepared_query->bindParam(':nomparent', $nomparent);
		$prepared_query->bindParam(':id', $id);

		if ($prepared_query->execute())
			return true;
		else return false;
	}

	function delete(){
		$database = bdd::getInstance()->getInstancePDO();

		$id = $this->getId();
		$query  = "DELETE FROM eleve WHERE id_eleve = :id;";

		$prepared_query = $atabase->prepare($query);
		$prepared_query->bindParam(':id', $id);

		if ($prepared_query->execute()){
			$this->setId(null);
			return true;
		}
		else return false;
	}
}
?>
