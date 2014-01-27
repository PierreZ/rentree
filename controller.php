<?php
require_once(ROOT."/model/eleve.php");
require_once(ROOT."/model/admin.php");

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

/*
*
* -------------------------------------
* All the functions associate to eleve
* -------------------------------------
*
*/

function get_eleve(){
	/*if(!is_admin() && !is_self(params("id"))) /// TODO
		return generate_403();
    */

	$e = Eleve::find((int)params("id"));
	if(!$e)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($e);
}

function post_eleve(){
	$e = Eleve::fromJson(file_get_contents("php://input"));
	$e->insert();
	header("Content-Type: application/json");
	return json_encode($e);
}

function put_eleve(){
	$e = Eleve::find((int)params("id"));

	if(!$e)
		return generate_404();

	$e->patch($GLOBALS["_PUT"]);
	$e->update();

	header("Content-Type: application/json");
	return json_encode($e);
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

/*
*
* -------------------------------------
* All the functions associate to Documents
* -------------------------------------
*
*/

function get_document(){

	$d = Documents::find(params("id"));
	if(!$d)
		return generate_404();

	return json_encode($d);
}

function post_document(){
	
	$d->patchFromJson(file_get_contents("php://input"));
	$d->insert($d);
	if(!$d)
		return generate_404();
	return $d;
}

function put_document(){

	$d->patchFromJson(file_get_contents("php://input"));
	$d->update(params("id"));
	if(!$d)
		return generate_404();
	return $d;
}

function download_document(){
	$d = Documents::find(params("id"));
	if(!$d)
		return generate_404();

	return json_encode($d.getFichier());
}

/*
*
* -------------------------------------
* All the functions associate to promos
* -------------------------------------
*
*/
function get_promo(){

	$d = Promotion::find(params("id"));
	if(!$d)
		return generate_404();

	return json_encode($d);
}

function post_promo(){
	
	$d->patchFromJson(file_get_contents("php://input"));
	$d->insert($d);
	if(!$d)
		return generate_404();
	return $d;
}

function put_promo(){

	$d->patchFromJson(file_get_contents("php://input"));
	$d->update(params("id"));
	if(!$d)
		return generate_404();
	return $d;
}

function pong(){
	return "pong";
}

function get_admin(){
	/*if(!is_admin()) /// TODO
		return generate_403();
    */

	$e = Admin::find(params("id"));
	if(!$e)
		return generate_404();

	return json_encode($e);
}

function serve_client_app(){
	return render('login.php'); 
}

?>
