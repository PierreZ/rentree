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
	if(!is_admin() && !is_self(params("id"))
		return generate_403();

	$e = Eleve.find($id=params("id"));
	if(!$e)
		return generate_404();

	return $e.toJson();
}

function pong(){
	return "pong";
}
?>
