<?php
require_once(ROOT."/model/eleve.php");

function generate_403($type="json", $error="Forbidden"){
	header("HTTP/1.1 403 Forbidden");
	if($type="json"){
		header("Content-Type: application/json");
		return json_encode(Array("error" => $error));
	}
}

function generate_404($type="json", $error="Not Found"){
	header("HTTP/1.1 404 Not Found");
	if($type="json"){
		header("Content-Type: application/json");
		return json_encode(Array("error" => $error));
	}
}
function get_eleve(){
	/*if(!is_admin() && !is_self(params("id"))) /// TODO
		return generate_403();
    */

	$e = Eleve::find(params("id"));
	if(!$e)
		return generate_404();

	return json_encode($e);
}

function post_eleve(){
	
	$e->patchFromJson(file_get_contents("php://input"));
	$e->insert($e);
	if(!$e)
		return generate_404();
	return true;
}

function put_eleve(){

	$e->patchFromJson(file_get_contents("php://input"));
	$e->update(params("id"));
	if(!$e)
		return generate_404();
	return true;
}

function get_eleves(){
	
	$array=Eleve::findAll();
	if(!$array)
		return generate_404();
	$serialize=Array();
	foreach($array as  $eleve{
		array_push($serialize,$eleve);
	}
	return json_encode($serialize);
}

function get_document(){

	$d = Documents::find(params("id"));
	if(!$d)
		return generate_404();

	return json_encode($d);
}

function pong(){
	return "pong";
}

?>
