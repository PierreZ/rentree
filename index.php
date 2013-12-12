<?php

require_once("conf/config.php");

require_once("lib/limonade.php");
require_once("controller.php");

//dispatch("/", "serve_client_app");

dispatch("/eleve/:id", "get_eleve");
dispatch_post("/eleve/", "post_eleve");
dispatch_put("/eleve/:id", "put_eleve");

dispatch("/eleves/", "get_eleves");

//dispatch("/document/:id", "get_document");
//dispatch_post("/document/", "post_document");
//dispatch_put("/document/:id", "put_document");

//dispatch("/document/:id.pdf", "download_document");

//dispatch("/documents/", "get_documents");


//dispatch_post("/session", "post_session");
//dispatch_delete("/session/:admin_id", "delete_session");

//dispatch("/admin/:id", "get_admin");
//dispatch_post("/admin/", "post_admin");
//dispatch_put("/admin/:id", "put_admin");
//dispatch_delete("/admin/:id", "delete_admin");

//dispatch("/admins/", "get_admins");

dispatch("/ping", "pong");

run();

?>
