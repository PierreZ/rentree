function AdminCtrl($scope, $rootScope, $cookies, $location, $http, $q){
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

	$scope.commit_promotion = function commit_promotion(promo){
		promo.waiting = true;
		promo.editing = false;
		$http({
			method: promo.id?"PUT":"POST",
			url: "promo/" + (promo.id?promo.id:""),
			data: promo
		}).then(function success(resp){
			$.extend(promo, resp.data);
			promo.waiting = false;
			promo.success = "success";
		},httperr);
	}

	$scope.delete_promotion = function delete_promotion(promo){
		var del = function del(){
			var pos = $scope.promotions.indexOf(promo);
			if(pos != -1)
				$scope.promotions.splice(pos, 1);
		}
		if(promo.id == 0) del();
		else $http({
			method: "DELETE",
			url: "promo/" + promo.id
		}).then(del, httperr);
	}

	$scope.commit_document = function commit_document(doc){
		doc.waiting = true;
		doc.editing = false;
		return $http({
			method: "PUT",
			url: "document/" + doc.id,
			data: doc
		}).then(function success(resp){
			$.extend(doc, resp.data);
			doc.waiting = false;
			doc.success = "success";
		},httperr);
	}

	$scope.delete_document = function delete_document(doc){
		var del = function del(){
			var pos = $scope.documents.indexOf(doc);
			if(pos != -1)
				$scope.documents.splice(pos, 1);
		}
		if(doc.id == 0) del();
		else $http({
			method: "DELETE",
			url: "document/" + doc.id
		}).then(del, httperr);
	}

	$scope.new_promo = function new_promo(){
		$scope.promotions.push({"editing":true, "nompromotion":"Promotion sans nom"});
	}

	$scope.new_document = function new_document(promo){
		// file upload TODO
	}

	$rootScope.$on('dropEvent', function(evt, doc, promo) {
		if(!promo.editing){
			doc.id_promotion = promo.id;
			promo.expanded = true;
			$scope.commit_document(doc);
		}
	});

	requests = {};

	requests.eleves = $http({ method: "GET", url: "eleves/" })
		.then(function success(resp){
			$scope.eleves = resp.data;
		}, httperr);

	requests.promos = $http({ method: "GET", url: "promos/" })
		.then(function success(resp){
			$scope.promotions = resp.data;
			$scope.promotions.unshift({"nompromotion": "Documents communs à toutes les promotions", "id": null});
		}, httperr);

	requests.documents = $http({ method: "GET", url: "documents/" })
		.then(function success(resp){
			$scope.documents = resp.data;
		}, httperr);

	$q.all(requests).then(function(){ $scope.status = null; });

	$scope.uploaded = function uploaded(doc, promo){
		doc.id_promotion = promo.id;
		$scope.commit_document(doc).then(function(){
			$scope.documents.push(doc);
		})

	}
}
