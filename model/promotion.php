<?php

class Promotion implements JsonSerializable{
	private $id_promotion;
	private $nompromotion;
	private $documents = Array();

	function __construct($nompromotion=null){
		
		$this->nompromotion=$nompromotion;
		
	}

	function __destruct(){
	}

	function getId(){
		return $this->id_promotion;
	}

	function setId($id){
		$this->id_promotion=$id;
	}
	

	function getNomPromotion(){
		return $this->nompromotion;
	}

	function setNomPromotion($nompromotion){
		$this->nompromotion=$nompromotion;
	}

	function pushDocument($document){
		array_push($this->documents, $document);
	}


	function jsonSerialize(){
		$ret = Array(
			"id" => $this->getId(),
			"nompromotion" => $this->getNomPromotion()
		);
		if($this->documents)
			$ret['documents'] = array_map(function($document){return $document->jsonSerialize();}, $this->documents);
		return $ret;
	}
	
	function patch($values){
		foreach($values as $key => $value){
			switch($key){
			case "id":
				$this->setId($value);
				break;
			case "nompromotion":
				$this->setNomPromotion($value);
				break;
			}
		}
	}

	function patchFromJson($json){
		$this->patch(json_decode($json));
	}
	static function fromJson($json){
		$e=new Promotion();
		$e->patchFromJson($json);
		return $e;
	}

	static function get($id=null){
		$database = bdd::getInstance()->getInstancePDO();
			
		$query  = "SELECT * FROM promotion WHERE id_promotion = :id;";
		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':id', $id);
	
		if (($prepared_query->execute())&&($prepared_query->rowCount()>0)){
			$resultat = $prepared_query->fetch(PDO::FETCH_ASSOC);
			
			$promo=new Promotion($resultat['nompromotion']);
			$promo->setId($resultat['id_promotion']);
			return $promo;
		}else return false;	
	}

	static function getall($full=false){
		$database = bdd::getInstance()->getInstancePDO();
		if($full)
			$query = "SELECT promotion.id_promotion, promotion.nompromotion, document.id_document, document.nom, document.fichier FROM promotion NATURAL JOIN document";
		else
			$query = "SELECT * FROM promotion";
		$prepared_query = $database->prepare($query);
		if ($prepared_query->execute()&&$prepared_query->rowCount()>0){
			$promos = Array();
			while($row = $prepared_query->fetch()){
				if(!$full){
					$promo=new Promotion($row['nompromotion']);
					$promo->setId($row['id_promotion']);
					array_push($promos, $promo);
				}
				else {
					if(!array_key_exists($row['id_promotion'], $promos)){
						$promo=new Promotion($row['nompromotion']);
						$promo->setId($row['id_promotion']);
						$promos[$row['id_promotion']] = $promo;
					}
					$document=new Document($row['fichier'],$row['id_promotion']);
					$document->setId($row['id_document']);
					$document->setNom($row['nom']);
					$promos[$row['id_promotion']]->pushDocument($document);
				}
			}
		}
		if($full) $promos = array_values($promos); // turn into non-associative array
		return $promos;
	}

	function insert(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_promotion=$this->getId();
		$nompromotion=$this->getNomPromotion();
		$query  = "INSERT INTO promotion (nompromotion) VALUES (:nompromotion);";
		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':nompromotion', $nompromotion);

		if ($prepared_query->execute()){
			$this->setId($database->lastinsertid());
			return true;
		}else return false;	
	}

	function update(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_promotion=$this->getId();
		$nompromotion=$this->getNomPromotion();

		$query  = "UPDATE promotion SET  nompromotion=:nompromotion WHERE id_promotion = :id_promotion;";
		$prepared_query = $database->prepare($query);
	    $prepared_query->bindParam(':id_promotion', $id_promotion);
		$prepared_query->bindParam(':nompromotion', $nompromotion);
		if ($prepared_query->execute())
			return true;
		else return false;
	}

	function delete(){
		$database = bdd::getInstance()->getInstancePDO();

		$id = $this->getId();
		$query  = "DELETE FROM promotion WHERE id_promotion = :id_promotion;";

		$prepared_query = $database->prepare($query);
		$prepared_query->bindParam(':id_promotion', $id);

		if ($prepared_query->execute()){
			$this->setId(null);
			return true;
		}
		else return false;
	}

	function findDocuments(){
		return Document::findForPromo($this->getId());
	}
}
?>
