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

	$e = Eleve::find($id=params("id"));
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

function pong(){
	return "pong";
}

?>
