function LoginCtrl($scope, $http, $location) {
	$scope.bodyClass = "login";
	$scope.status = null;
	$scope.error = null;

	$scope.login = function login(){
		$scope.status = "loading";
		$http({
			method: "POST",
			data: {
				email: $scope.email,
				password: $scope.password
			},
			url: "session/",
			timeout: 5000
		}).then(function success(resp){
			$scope.status = null;
			$location.path("/eleve");
		},function error(resp){
			$scope.status = null;
			if(resp.data.error)
				$scope.error = resp.data.error;
			else
				$scope.error = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
		});
	}
}
