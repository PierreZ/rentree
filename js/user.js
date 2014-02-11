function EleveCtrl($scope, $rootScope) {
	if($rootScope.fading){
		$scope.bodyClass = "step-0 panes fade";
		setTimeout(function(){document.body.classList.remove("fade");}, 0);
		$rootScope.fading = false;
	}
	else {
		$scope.bodyClass = "step-0 panes";
	}
}
