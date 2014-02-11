function RentreeCtrl($scope) {

	// Initialisation des tableaux
	$scope.promos=new Array();
	$scope.documents=new Array();

	//Initialisation de l'objet eleve
	$scope.eleve = {};

	// Initialisation de l'ID de l'élève
	$scope.eleve_id = 0;

	// Initialisation de la promo choisie
	// Selected permet de savoir quel promo à été choisies(plus précisément son ID)
	$scope.selected=0;

	// Chargement des méthodes d'initialisation
	$scope.init= function (){
		$scope.init_eleve();
		$scope.init_promos();
		$scope.init_documents();
	}

	// Fonction permettant le login et la création de la session
	$scope.login = function (){
		var b = document.querySelector("button");
		b.disabled = true;
		b.classList.add("loading");

		document.activeElement.blur();
		var URL = window.location.protocol + "//" + window.location.host + window.location.pathname +"?uri=session";
		var email=$('#email').val(),
			paswd=$('#password').val();

		//Verification que les champs ne sont pas vides
		if (email.length < 1 || paswd.length < 1) {
			var b = document.querySelector("button");
			b.disabled = false;
			b.classList.remove("loading");
			return false;
		};
		// Début de la requête AJAX
		jQuery.ajax({
			type: 'POST',
			url: URL,
			data: {
				email: email,
				password: paswd
			},
			statusCode: {
				403: function() {
					var b = document.querySelector("button");
					b.disabled = false;
					b.classList.remove("loading");
					return false;
				}
			},
			success: function(data) {
				// Ajout des info de login dans les cookies
				document.cookie = "session_key=" + data.key;
				if(!data.is_admin){
					document.cookie = "id_eleve=" + data.id;
					$scope.eleve_id = data.id;
					$scope.is_admin = false;
				}
				else{
					$scope.admin_id = data.id;
					$scope.is_admin = true;
				}

				// changement des classes pour le CSS
				document.body.classList.add("fade");
				window.setTimeout(function(){
					document.body.classList.remove("login");
					if(data.is_admin){
						document.body.innerHTML = document.querySelector("template.admin").innerHTML;
						document.body.classList.add("admin");
						//initAdmin();
					}
					else {
						document.body.innerHTML = document.querySelector("template.panes").innerHTML;
						document.body.classList.add("step-0");
						document.body.classList.add("panes");
						initPanes();
					}
					window.setTimeout(function(){
						document.body.classList.remove("fade");
					}, 100, false);
				},  1000, false);
				$scope.init();
			}
		});
	}

	$scope.init_eleve= function(){
		var URL = window.location.protocol + "//" + window.location.host + window.location.pathname +"?uri=eleve/"+$scope.eleve_id;
		jQuery.ajax({
			type: 'GET',
			url: URL,
			success: function(data) {
				$scope.$apply(function(){
					window.scope = $scope;
					console.dir(window.scope.eleve);
					$scope.eleve=data;
				});
			}
		});
	}
	$scope.init_promos= function(){
		var URL = window.location.protocol + "//" + window.location.host + window.location.pathname +"?uri=promos/";
		jQuery.ajax({
			type: 'GET',
			url: URL,
			success: function(data) {
				$scope.promos=data;
			}
		});
	}
	$scope.init_documents = function(){
		var URL = window.location.protocol + "//" + window.location.host + window.location.pathname +"?uri=documents/";
		jQuery.ajax({
			type: 'GET',
			url: URL,
			success: function(data) {
				$scope.documents=data;
			}
		});
	}

	//Fonction submit des infos des étudiants
	$scope.submit = function(){

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
		var URL = window.location.protocol + "//" + window.location.host + window.location.pathname +"?uri=eleves/"+$scope.eleve_id;

		var b = document.querySelector("button");
		b.disabled = true;
		b.classList.add("loading");

		document.activeElement.blur();

		//Requête AJAX pour mettre à jour les infos
		jQuery.ajax({
			type: 'PUT', 
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
