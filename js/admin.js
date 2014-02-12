function AdminCtrl($scope, $cookies, $location, $http, $q){
	$scope.bodyClass="admin";
	$scope.status="loading";
	$scope.mode="documents";

	function httperr(resp){
		if(resp.status == 403)
			$scope.logout();
		else if(resp.data && resp.data.error)
			$scope.error=resp.data.error;
		else
			$scope.error="Une erreur est survenue. Veuillez réessayer ultérieurement.";
	}

	$scope.logout = function logout(){
		delete $cookies.session_key;
		$location.path('/login/');
	}

	$scope.commit_eleve = function commit_eleve(eleve){
		eleve.waiting = true;
		eleve.editing = false;
		eleve.success = false;
		$http({
			method: eleve.id?"PUT":"POST",
			url: "eleve/" + (eleve.id?eleve.id:""),
			data: eleve
		}).then(function success(resp){
			$.extend(eleve, resp.data);
			eleve.waiting = false;
			eleve.success = "success";
		},httperr);
	}

	$scope.delete_eleve = function delete_eleve(eleve){
		var del = function del(){
			var pos = $scope.eleves.indexOf(eleve);
			if(pos != -1)
				$scope.eleves.splice(pos, 1);
		}
		if(eleve.id == 0) del();
		else $http({
			method: "DELETE",
			url: "eleve/" + eleve.id
		}).then(del, httperr);
	}

	requests = {};

	requests.eleves = $http({ method: "GET", url: "eleves/" })
		.then(function success(resp){
			$scope.eleves = resp.data;
		}, httperr);

	requests.promos = $http({ method: "GET", url: "promos/full" })
		.then(function success(resp){
			$scope.promotions = resp.data;
		}, httperr);

	$q.all(requests).then(function(){ $scope.status = null; });
}
