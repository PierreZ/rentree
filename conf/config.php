<?php
const DSN     = 'mysql:host=localhost;dbname=rentree';
const USER    = "root";
const PASSWD  = "rentree";
const ROOT    = "/srv/http/rentree/";
const WWWROOT = "http://localhost/rentree/?";
const DOCROOT = "docs/"; // relatif à ROOT
// Attention, DOCROOT doit être accessible en écriture par l'utilisateur ou le groupe sous lequel tourne PHP !

// Mot de passe pour les élèves
const PASS_ELEVE = "isen2015";

// Sel de hachage des sessions élève
// À changer lors de l'installation finale !
const SECRET = "yD6-IRa1gDy021vxKV2Iq-4kwipmQpyAu9SSJ_d8zwa-_5UEGt682CJrnAjIKrkfs9VX8OUUJlglcNKn_mtbKglFRWMGnPI56cqgQ8fV";
?>
