<?php
require_once(ROOT."/model/JsonSerialize.php");
require_once(ROOT."/model/eleve.php");
require_once(ROOT."/model/admin.php");
require_once(ROOT."/model/document.php");
require_once(ROOT."/model/promotion.php");
require_once(ROOT."/model/session.php");

function generate_204(){
	header("HTTP/1.1 204 No Content");
	return "";
}

function generate_400($type="json", $error="Bad Request"){
	header("HTTP/1.1 400 Bad Request");
	if($type="json"){
		header("Content-Type: application/json");
		return json_encode(Array("error" => $error));
	}
}

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

function generate_500($type="json", $error="Internal Server Error"){
	header("HTTP/1.1 500 Internal Server Error");
	if($type="json"){
		header("Content-Type: application/json");
		return json_encode(Array("error" => $error));
	}
}

function is_self($id){
	if(array_key_exists('id_eleve', $_COOKIE) && array_key_exists('session_key', $_COOKIE) &&
		$id == $_COOKIE['id_eleve'] && hash('sha256', $id . SECRET) === $_COOKIE['session_key'])
		return true;
	return false;
}

function is_admin(){
	if(array_key_exists('session_key', $_COOKIE) &&
		Session::fromKey($_COOKIE['session_key']))
		return true;
	return false;
}

/*
*
* -------------------------------------
* All the functions associate to eleve
* -------------------------------------
*
*/

function get_eleve(){
	if(!is_admin() && !is_self((int)params("id")))
		return generate_403();

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
	if(!is_admin() && !is_self((int)params("id")))
		return generate_403();

	$e = Eleve::find((int)params("id"));

	if(!$e)
		return generate_404();

	$e->patch($GLOBALS["_PUT"]);
	$e->update();

	header("Content-Type: application/json");
	return json_encode($e);
}

function get_eleves(){
	$eleves=Eleve::findAll();

	header("Content-Type: application/json");
	return json_encode($eleves);
}

/*
*
* -------------------------------------
* All the functions associate to Documents
* -------------------------------------
*
*/

function get_document(){
	$d = Document::get((int)params("id"));
	if(!$d)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($d);
}

function post_document(){
	if(!is_admin())
		return generate_403();
	
	if(!array_key_exists('doc', $_FILES))
		return generate_400();

	$file = $_FILES['doc'];
	$dest = ROOT . DOCROOT . $file['name'];
	if(!move_uploaded_file($file['tmp_name'], $dest))
		return generate_500();

	$d = new Document($file['name']);
	$d->setNom($file['name']);
	$d->insert();
	header("Content-Type: application/json");
	return json_encode($d);
}

function put_document(){
	if(!is_admin())
		return generate_403();

	$d = Document::get((int)params("id"));
	if(!$d)
		return generate_404();

	$d->patch($GLOBALS["_PUT"]);
	$d->update();

	header("Content-Type: application/json");
	return json_encode($d);
}

function delete_document(){
	if(!is_admin())
		return generate_403();

	$d = Document::get((int)params("id"));
	if(!$d)
		return generate_404();
	else {
		if($d->delete())
			return generate_204();
		else
			return generate_500();
	}
}

function download_document(){
	$d = Document::get((int)params(0));

	if(!$d || !file_exists(ROOT . DOCROOT . $d->getFichier()))
		return generate_404();

	header("Content-Type: application/pdf");
	ob_clean();
	flush();
	readfile(ROOT . DOCROOT . $d->getFichier());
}

function get_documents(){
	$d = Document::getall();
	if(!$d)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($d);
}

/*
*
* -------------------------------------
* All the functions associate to promos
* -------------------------------------
*
*/
function get_promo(){
	$p = Promotion::get((int)params("id"));
	if(!$p)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($p);
}

function get_promos(){
	$p = Promotion::getall();
	if(!$p)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($p);
}

function post_promo(){
	if(!is_admin())
		return generate_403();
	
	$p = Promotion::fromJson(file_get_contents("php://input"));
	$p->insert($p);
	if(!$p)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($p);
}

function put_promo(){
	if(!is_admin())
		return generate_403();

	$p = Promotion::get((int)params("id"));

	$p->patch($GLOBALS["_PUT"]);
	$p->update();
	if(!$p)
		return generate_404();

	header("Content-Type: application/json");
	return json_encode($p);
}

function delete_promo(){
	if(!is_admin())
		return generate_403();

	$p = Promotion::get((int)params("id"));
	if(!$p)
		return generate_404();
	else {
		if($p->delete())
			return generate_204();
		else
			return generate_500();
	}

}

function get_promo_documents(){
	$docs = Document::forPromo((integer)params("id"));

	header("Content-Type: application/json");
	return json_encode($docs);
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
	return render('elements/login.php');
}

function post_session(){
	if(!array_key_exists('email', $_POST) || !array_key_exists('password', $_POST))
		return generate_400("json", "Missing email or password");
	$sess = new Session($_POST['email'], $_POST['password']);

	if($sess->logIn()){
		header("Content-Type: application/json");
		return json_encode($sess);
	}
	else return generate_403();
}

?>
