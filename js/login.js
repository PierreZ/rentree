function LoginCtrl($scope, $rootScope, $http, $location, $cookies) {
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

			var session = $rootScope.session = resp.data;

			$cookies.session_key = session.key
			if(!session.is_admin) $cookies.id_eleve = ""+session.id

			function finishLogin(e){
				document.body.removeEventListener('transitionend', finishLogin);
				if($rootScope.session.is_admin)
					$scope.$apply($location.path("/admin/"));
				else
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
