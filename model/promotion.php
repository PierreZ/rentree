<?php

class Promotion{
	private $id_promotion;
	private $nompromotion;

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

	function setNomPromotion($id){
		$this->nompromotion=$nompromotion;
	}


	function toJson(){
		return json_encode(Array(
			"id" => $this->getId();
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
			case "nompromotion":
				$this->setNomPromotion($value);
				break;
			}
		}
	}
	static function fromJson($json){
		$e=new Promotion();
		$e->patchFromJson($json);
		return $e;
	}

	static function find($id=null){
		
		database = bdd::getInstance()->getInstancePDO();
			
		$query  = "SELECT * FROM promotion WHERE id_promotion = :id;"; 
		$prepared_query =database->prepare($query);
		$prepared_query->bindParam(':id', $id);
	
		if (($prepared_query->execute())&&($prepared_query->rowCount()>0)){
			$resultat = $prepared_query->fetch(PDO::FETCH_ASSOC);
			
			$promo=new Promotion($resultat['id_promotion']);
			$prom->setNomPromotion($resultat['nompromotion']);
			return $promo;
		}else return false;	
	}

	function insert(){
		$database = bdd::getInstance()->getInstancePDO();
		
		$id_promotion=$this->getId();
		$nompromotion=$this->getNomPromotion();
		$query  = "INSERT INTO promotion (id_promotion, id_promotion) VALUES (:id,:id_promotion);";
		$prepared_query = $database->prepare($query);
	    $prepared_query->bindParam(':id_promotion', $id_promotion);
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

		$prepared_query = $atabase->prepare($query);
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
