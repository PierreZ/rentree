<?php

class Document{
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


	function toJson(){
		return json_encode(Array(
			"id" => $this->getId();
			"fichier" => $this->getFichier();
			"nompromotion" => $this->getNomPromotion();
		));
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
		if(is_int($nompromotion)==TRUE){
			//ID
			$query  = "SELECT * FROM document WHERE id = :id;"; 
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

}
?>
