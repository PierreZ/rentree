<?php

class Document implements JsonSerializable{
	private $id_document;
	private $fichier;
	private $id_promotion;
	private $nom;

	function __construct($fichier, $id_promotion=0){
		$this->setFichier($fichier);
		$this->setIdPromotion($id_promotion);
	}

	function __destruct(){
	}

	function getId(){
		return $this->id_document;
	}

	function setId($id){
		$this->id_document=$id;
	}
	
	function getFichier(){
		return $this->fichier;
	}

	function setFichier($fichier){
		$this->fichier=$fichier;
	}

	function getIdPromotion(){
		return $this->id_promotion;
	}

	function setIdPromotion($id){
		$this->id_promotion = $id;
	}

	function getNom(){
		return $this->nom;
	}

	function setNom($nom){
		$this->nom=$nom;
	}

	function jsonSerialize(){
		return Array(
			"id" => $this->getId(),
			"fichier" => $this->getFichier(),
			"id_promotion" => $this->getIdPromotion(),
			"nom" => $this->getNom()
		);
	}
	
	function patch($values){
		foreach($values as $key => $value){
			switch($key){
			case "id":
				$this->setId($value);
				break;
			case "fichier":
				$this->setFichier($value);
				break;
			case "id_promotion":
				$this->setIdPromotion($value);
				break;
			case "nom":
				$this->setNom($value);
				break;
			}
		}
	}

	function patchFromJson($json){
		$values=json_decode($json);
		$this->patch($values);
	}
	static function fromJson($json){
		$e=new Document();
		$e->patchFromJson($json);
		return $e;
	}

	// Given an ID, gets the document with that ID.
	static function get($id=0){
		$database = bdd::getInstance()->getInstancePDO();

		$query = "SELECT fichier, id_promotion, nom FROM document WHERE id_document = :id;";
		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':id', $id);
		if ($prepared_query->execute()&&$prepared_query->rowCount()>0){
			$resultat = $prepared_query->fetch();

			$document=new Document($resultat['fichier'],$resultat['id_promotion']);
			$document->setId($id);
			$document->setNom($resultat['nom']);
			return $document;
		}else return false;
	}

	static function forPromo($promoid=0){
		$database = bdd::getInstance()->getInstancePDO();

		if($promoid == 0){
			$query = "SELECT id_document, fichier, nom FROM document WHERE id_promotion IS NULL";
			$prepared_query = $database->prepare($query);
		} else {
			$query = "SELECT id_document, fichier, nom FROM document WHERE id_promotion = :id;";
			$prepared_query = $database->prepare($query);
			$prepared_query->bindValue(':id', $promoid);
		}
		if ($prepared_query->execute()){
			$docs = Array();
			while($row = $prepared_query->fetch()){
				$doc=new Document($row['fichier'], $promoid);
				$doc->setId($row['id_document']);
				$doc->setNom($row['nom']);
				array_push($docs, $doc);
			}
			return $docs;

		}else return false;
	}

	function insert(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_document=$this->getId();
		$fichier=$this->getFichier();
		$id_promotion=$this->getIdPromotion();
		$nom=$this->getNom();
		$query  = "INSERT INTO document (id_document, fichier, id_promotion, nom) VALUES (:id_document,:fichier,:id_promotion,:nom);";
		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':id_document', $id_document);
		$prepared_query->bindParam(':fichier', $fichier);
		$prepared_query->bindParam(':id_promotion', $id_promotion);
		$prepared_query->bindParam(':nom', $nom);

		if ($prepared_query->execute()){
			$this->setId($database->lastinsertid());
			return true;
		} else return false;
	}

	function update(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_document=$this->getId();
		$fichier=$this->getFichier();
		$id_promotion=$this->getIdPromotion();
		$nom=$this->getNom();

		$query  = "UPDATE document SET fichier=:fichier, id_promotion=:id_promotion, nom=:nom WHERE id_document = :id_document;";
		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':id_document', $id_document);
		$prepared_query->bindParam(':fichier', $fichier);
		$prepared_query->bindParam(':id_promotion', $id_promotion);
		$prepared_query->bindParam(':nom', $nom);
		if ($prepared_query->execute())
			return true;
		else return false;
	}

	function delete(){
		$database = bdd::getInstance()->getInstancePDO();

		$id = $this->getId();
		$query  = "DELETE FROM document WHERE id_document = :id_document;";

		$prepared_query = $database->prepare($query);
		$prepared_query->bindValue(':id_document', $id);

		if ($prepared_query->execute()){
			$this->setId(null);
			unlink($this->fichier);
			return true;
		}
		else return false;
	}

}
?>
