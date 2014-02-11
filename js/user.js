function EleveCtrl($scope, $rootScope, $http, $cookies, $location) {
	
	$scope.bodyClass = "step-0 panes fade";
	$scope.status = null;
	$scope.error = null;
	// Initialisation de la promo choisie
	// Selected permet de savoir quel promo à été choisies(plus précisément son ID)
	$scope.selected=0;
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
		$scope.bodyClass = "step-2 panes";
	}, function error(resp){
		if(resp.status == 403 && $rootScope.session)
			$scope.eleve = { email: $rootScope.session.email };
		$scope.bodyClass = "step-0 panes";
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
			$scope.error = resp.data.error;
		else
			$scope.error = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
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
			$scope.error = resp.data.error;
		else
			$scope.error = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
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
;
					return;
				};
		$http({
			method: "PUT",
			data: $scope.eleve,
			url: "eleve/" + $cookies.id_eleve,
			timeout: 5000
		}).then(function success(resp){
			document.body.classList.add("step-2");
			document.body.classList.remove("step-1");
			$scope.status = null;

		},function error(resp){
			$scope.status = null;
			if(resp.data.error)
				$scope.error = resp.data.error;
			else
				$scope.error = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
		});
	}
}
