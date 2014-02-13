function EleveCtrl($scope, $rootScope, $http, $cookies, $location) {
	
	$scope.bodyClass = "step-0 panes fade";
	$scope.status = null;
	$scope.error_form = null;
	$scope.error_documents = null;
	$scope.error_promos = null;
	// Initialisation de la promo choisie
	// Selected permet de savoir quel promo à été choisies(plus précisément son ID)
	$scope.selected_promo=0;
	$scope.documents = {};	

	// Initialisation des tableaux
	$scope.promos=new Array();
	$scope.documents=new Array();

	// Récupération des éléments
	$http({
		method: "GET",
		url: "eleve/" + $cookies.id_eleve
	}).then(function success(resp){
		$scope.eleve = resp.data;
		$scope.set_panel(2);
		}, function error(resp){
			if(resp.status == 403 && $rootScope.session)
				$scope.eleve = { email: $rootScope.session.email };
		$scope.set_panel(0);
	});

	// Récupération des promos
	$http({
		method: "GET",
		url: "promos/",
		timeout: 5000
	}).then(function success(resp){
		$scope.promos=resp.data;
	},function error(resp){
		$scope.status = null;
		if(resp.data.error)
			$scope.error_promos = resp.data.error;
		else
			$scope.error_promos = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
	});

	// Récupération des documents
	$http({
		method: "GET",
		url: "documents/",
		timeout: 5000
	}).then(function success(resp){
		$scope.documents=resp.data;
	},function error(resp){
		$scope.status = null;
		if(resp.data.error)
			$scope.error_documents = resp.data.error;
		else
			$scope.error_documents = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
	});

	// Fonction d'envoi des coord de l'élève
	$scope.submit_infos = function submit_infos(){
		$scope.status = "loading";
		// Si le formulaire n'est pas complet
		if ($scope.eleve.nom.length < 1 || $scope.eleve.email.length < 1 || $scope.eleve.datenaissance.length < 1
				|| $scope.eleve.emailparent.length < 1  || $scope.eleve.telparent.length < 1
				|| $scope.eleve.nomparent.length < 1) {
					$scope.status = null;
					$scope.error = "Merci de remplir tout les champs";
					return;
				};
		$http({
			method: $scope.eleve.id?"PUT":"POST",
			data: $scope.eleve,
			url: "eleve/" + ($scope.eleve.id?$scope.eleve.id:""),
			timeout: 5000
		}).then(function success(resp){
			document.body.classList.add("step-2");
			document.body.classList.remove("step-1");
			$scope.status = null;
		},function error(resp){
			$scope.status = null;
			if(resp.data.error)
				$scope.error_form = resp.data.error;
			else
				$scope.error_form = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
		});
	}
	// Permet de setter la promo choisie
	$scope.select_promo= function(promo) {
		$scope.selected_promo = promo;
		$scope.set_panel(3);
	};
	// Permet de setter le document choisi
	$scope.select_document= function(document) {
		$scope.selected_document = document;
		$scope.set_panel(4);
	};
	// Permet de setter le futur panel
	$scope.set_panel = function(next_panel){
		$scope.bodyClass = "step-"+next_panel+" panes";
		},function error(resp){
			$scope.status = null;
			if(resp.data.error)
				$scope.error = resp.data.error;
			else
				$scope.error = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
		

	};
}
