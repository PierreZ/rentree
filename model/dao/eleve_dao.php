<?php
include_once "$root/model/dao/dao.php";
include_once "$root/model/eleve.php";

class Eleve_dao {
	
	public $database;

	
	public function __construct(){
	                $this->database = bdd::getInstance()->getInstancePDO();
	}	
	
	function find($id=null,$email=null){
		if(is_null($email)==TRUE){	
			$query  = "SELECT * FROM eleve WHERE id = :id;"; 
			$prepared_query = $this->database->prepare($query);
			$prepared_query->bindParam(':id', $id);

		}else{
			$query  = "SELECT * FROM eleve WHERE email = :email;"; 
			$prepared_query = $this->database->prepare($query);
			$prepared_query->bindParam(':email', $email);
		}		
			if (($prepared_query->execute())&&($prepared_query->rowCount()>0)){
				$resultat = $prepared_query->fetch(PDO::FETCH_ASSOC);
				
				$nom = $resultat['nom'];
			        $email = $resultat['email'];
	  			$datenaissance = $resultat['datenaissance'];
				$emailparent = $resultat['emailparent'];
				$telparent = $resultat['telparent'];
				$nomparent = $resultat['nomparent'];

				$eleve = new Eleve($nom,$email,$datenaissance,$emailparent,$telparent,$nomparent);
				$eleve->setId($id);    
				return $eleve;
			}
			else return false;
	}
	
	function insert(&$object){
			
		$nom = $object->getNom();
	        $email = $object->getEmail();
	  	$datenaissance =$object->getDateNaissance();
		$emailparent = $object->getEmailParent();
		$telparent = $object->getTelParent();
		$nomparent = $object->getNomParent();
		$query  = "INSERT INTO eleve (email, nom, datenaissance, emailparent, telparent, nomparent) VALUES (:email,:nom,:datenaissance,:emailparent, :telparent, :nomparent);";
	
		$prepared_query = $this->database->prepare($query);
		$prepared_query->bindParam(':email', $email);
		$prepared_query->bindParam(':nom', $nom);
		$prepared_query->bindParam(':datenaissance', $datenaissance);
		$prepared_query->bindParam(':emailparent', $emailparent);
		$prepared_query->bindParam(':telparent', $telparent);
		$prepared_query->bindParam(':nomparent', $nomparent);
    		if ($prepared_query->execute()){
			$object->setEtudiant_id($this->database->lastinsertid());
			return true;
		}
        	else return false;
	}
		
	function update(&$object){
		
		$id = $object->getId();
		$nom = $object->getNom();
	        $email = $object->getEmail();
	  	$datenaissance =$object->getDateNaissance();
		$emailparent = $object->getEmailParent();
		$telparent = $object->getTelParent();
		$nomparent = $object->getNomParent();
		$query  = "UPDATE eleve SET nom=:nom, email=:email, datenaissance=:datenaissance, emailparent=:emailparent, telparent=:telparent,nomparent=:nomparent WHERE id = :id;";
		$prepared_query = $this->database->prepare($query);
		$prepared_query->bindParam(':email', $email);
		$prepared_query->bindParam(':nom', $nom);
		$prepared_query->bindParam(':datenaissance', $datenaissance);
		$prepared_query->bindParam(':emailparent', $emailparent);
		$prepared_query->bindParam(':telparent', $telparent);
		$prepared_query->bindParam(':nomparent', $nomparent);
		$prepared_query->bindParam(':id', $id);
		
		if ($prepared_query->execute()){
			return true;
		}
		else return false;
	}
	
	function delete(&$object){
		$id = $object->getId();
		$query  = "DELETE FROM eleve WHERE id = :id;";

		$prepared_query = $this->database->prepare($query);
		$prepared_query->bindParam(':id', $id);

		if ($prepared_query->execute()){
			$object=null;
			return true;
		}
		else return false;
	}
}
?>
