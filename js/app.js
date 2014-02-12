var rentree = angular.module('rentree', ['ngRoute', 'ngCookies']);

rentree.config(['$routeProvider',
	function($routeProvider){
		$routeProvider.when("/login", {
			templateUrl: 'views/elements/login.html',
			controller: 'LoginCtrl'
		}).when("/eleve", {
			templateUrl: 'views/elements/user.html',
			controller: 'EleveCtrl'
		}).when("/admin", {
			templateUrl: 'views/elements/admin.html',
			controller: 'AdminCtrl'
		}).otherwise({ redirectTo: '/login' });
	}
]);
