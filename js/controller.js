function RentreeCtrl($scope) {

// Initialisation des tableaux
$scope.promos=new Array();
$scope.documents=new Array();

//Initialisation de l'objet eleve
$scope.eleve = {};

// Initialisation de la promo choisie
// Selected permet de savoir quel promo à été choisies(plus précisément son ID)
$scope.selected=0;

// Chargement des méthodes d'initialisation
function init(){
  init_eleve();
  init_promos();
  init_documents();
}

function init_eleve(){
    var URL = window.location.protocol + "//" + window.location.host+"?/eleve/"+eleve_id;
  jQuery.ajax({
    type: 'GET', 
    url: URL,
    success: function(data) {
      $scope.eleve=data;
    }
  });
}
function init_promos(){
    var URL = window.location.protocol + "//" + window.location.host+"?/promos/";
  jQuery.ajax({
    type: 'GET', 
    url: URL,
    success: function(data) {
      $scope.promos=data;
    }
  });
}
function init_documents(){
    var URL = window.location.protocol + "//" + window.location.host+"?/documents/";
  jQuery.ajax({
    type: 'GET', 
    url: URL,
    success: function(data) {
      $scope.documents=data;
    }
  });
}

//Fonction submit des infos des étudiants
function submit(){
  $scope.init();

    // Si le formulaire n'est pas complet
     if ($scope.eleve.nom.length < 1 || $scope.eleve.email.length < 1 || $scope.eleve.datenaissance.length < 1
     || $scope.eleve.emailparents.length < 1  || $scope.eleve.telparents.length < 1
      || $scope.eleve.nomparents.length < 1) {
         var button = document.querySelector(".contact button");
         button.querySelector(".label").innerHTML="Formulaire incomplet";
         window.setTimeout(function() {button.querySelector(".label").innerHTML="Envoyer";}, 1000, false);
        return;
        };

    // On stocke les éléments du formulaire
    var URL = window.location.protocol + "//" + window.location.host+"?/eleves/"+eleve_id;

    var b = document.querySelector("button");
    b.disabled = true;
    b.classList.add("loading");

    document.activeElement.blur();

    //Requête AJAX pour mettre à jour les infos
    jQuery.ajax({
        type: 'POST', 
        url: URL,
        data: $scope.eleve ,
        statusCode: {
            403: function() {
                b.querySelector(".label").innerHTML="Envoyer";
                b.disabled = false;
            }
        },
        success: function(data) {
            window.setTimeout(function(){b.classList.add("success"); b.classList.remove("loading");}, 1000, false);
            window.setTimeout(function(){
                document.body.classList.add("step-2");
                document.body.classList.remove("step-1");
                var button = document.querySelector(".contact button");
                button.disabled = false;
                button.classList.remove("success");
                button.querySelector(".label").innerHTML="Mettre à jour";
            }, 1500, false);

        }
    });
}

$scope.select= function(promo) {
  $scope.selected = promo; 
};

}