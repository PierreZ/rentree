function EleveCtrl($scope, $rootScope, $http, $cookies, $location) {
	$scope.bodyClass = "step-0 panes fade";

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

	$scope.submit_infos = function submit_infos(){
		console.log("rien lol");
	}
}
