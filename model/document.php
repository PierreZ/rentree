<?php

class Document implements JsonSerializable{
	private $document_id;
	private $fichier;
	private $nompromotion;

	function __construct($fichier=null,$nompromotion=null){
		
		$this->fichier=$fichier;
		$this->nompromotion=$nompromotion;
		
	}

	function __destruct(){
	}

	function getId(){
		return $this->document_id;
	}

	function setId($id){
		$this->document_id=$id;
	}
	
	function getFichier(){
		return $this->fichier;
	}

	function setFichier($fichier){
		$this->fichier=$fichier;
	}

	function getNomPromotion(){
		return $this->nompromotion;
	}

	function setNomPromotion($id){
		$this->nompromotion=$nompromotion;
	}


	function jsonSerialize(){
		return Array(
			"id" => $this->getId();
			"fichier" => $this->getFichier();
			"nompromotion" => $this->getNomPromotion();
		);
	}
	
	function patchFromJson($json){
		$values=json_decode($json);
		foreach($values as $key => $value){
			switch($key){
			case "id":
				$this:>setId($value);
				break;
			case "fichier":
				$this->setFichier($value);
				break;
			case "nompromotion":
				$this->setNomPromotion($value);
				break;
			}
		}
	}
	static function fromJson($json){
		$e=new Document();
		$e->patchFromJson($json);
		return $e;
	}

	static function find($id=null){
		
		database = bdd::getInstance()->getInstancePDO();
		if(is_int($id)==TRUE){
			//ID
			$query  = "SELECT * FROM document WHERE id_document = :id;"; 
			$prepared_query =database->prepare($query);
			$prepared_query->bindParam(':id', $id);
		}else{
			// Promotion
			$query  = "SELECT * FROM document WHERE nompromotion = :nompromotion;"; 
			$prepared_query = database->prepare($query);
			$prepared_query->bindParam(':nompromotion', $id);
		}
		if (($prepared_query->execute())&&($prepared_query->rowCount()>0)){
			$resultat = $prepared_query->fetch(PDO::FETCH_ASSOC);
			
			$fichier=$resultat['fichier'];
			$fichier=$resultat['nompromotion'];
			$document=new Document($fichier,$nompromotion);
			$document->setId($id);
		}else return false;	
	}

	static function insert(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_document=$this->getId();
		$fichier=$this->getFichier();
		$nompromotion=$this->getNomPromotion();
		$query  = "INSERT INTO document (id_document, fichier, id_promotion) VALUES (:id,:fichier,:id_promotion);";
		$prepared_query = $database->prepare($query);
	        $prepared_query->bindParam(':id_document', $id_document);
	        $prepared_query->bindParam(':fichier', $fichier);
		$prepared_query->bindParam(':nompromotion', $nompromotion);

		if ($prepared_query->execute()){
			$this->setId($database->lastinsertid());
			return true;
		}else return false;	
	}

	static function update(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_document=$this->getId();
		$fichier=$this->getFichier();
		$nompromotion=$this->getNomPromotion();

		$query  = "UPDATE document SET fichier=:fichier, nompromotion=:nompromotion WHERE id_document = :id_document;";
		$prepared_query = $database->prepare($query);
	        $prepared_query->bindParam(':id_document', $id_document);
	        $prepared_query->bindParam(':fichier', $fichier);
		$prepared_query->bindParam(':nompromotion', $nompromotion);
		if ($prepared_query->execute())
			return true;
		else return false;
	}

	static function delete(){
		$database = bdd::getInstance()->getInstancePDO();

		$id = $this->getId();
		$query  = "DELETE FROM document WHERE id_document = :id_document;";

		$prepared_query = $atabase->prepare($query);
		$prepared_query->bindParam(':id_document', $id);

		if ($prepared_query->execute()){
			$this->setId(null);
			return true;
		}
		else return false;
	}

}
?>
