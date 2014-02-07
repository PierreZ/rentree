function RentreeCtrl($scope) {

// Initialisation des tableaux
$scope.promos=new Array();
$scope.documents=new Array();

// Initialisation de la promo choisie
// Selected permet de savoir quel promo à été choisies(plus précisément son ID)
$scope.selected=0;


$scope.select= function(promo) {
  $scope.selected = promo; 
};

}