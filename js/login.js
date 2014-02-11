function LoginCtrl($scope, $rootScope, $http, $location) {
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
			if(resp.data.key != "")
				document.cookie = "session_key=" + resp.data.key;

			function finishLogin(e){
				document.body.removeEventListener('transitionend', finishLogin);
				$scope.$apply($location.path("/eleve/"));
			}

			document.body.addEventListener('transitionend', finishLogin);
			document.body.classList.add("fade");
			$rootScope.fading = true;

		},function error(resp){
			$scope.status = null;
			if(resp.data.error)
				$scope.error = resp.data.error;
			else
				$scope.error = "Une erreur inconnue est survenue. Veuillez réessayer plus tard.";
		});
	}
}
