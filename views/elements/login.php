<!doctype html>
<!--tout attribut commencant par ng-* est une balise spéciale pour AngularJS -->
<html lang="fr" ng-app>
<head>
    <title>Documents de rentrée</title>
    <link rel="stylesheet" href="style/somestyle.css"/>
    <script src="lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="lib/angular.min.js" type="text/javascript"></script>
    <script src="js/controller.js"></script>
    <script src="js/login.js"></script>
    <script src="js/panes.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
</head>
<!--Définition du controller-->
<body class="login" ng-controller="RentreeCtrl">
    <div class="logo-isen" style="font-size: 2Opx">
        <h1>ISEN</h1>
        <h2>documents de rentrée</h2>
    </div>
    <form>
        <label for="email">E-mail :</label>
        <input type="text" name="email" id="email"/>
        <label for="password">Mot de passe (reçu par e-mail) :</label>
        <input type="password" name="password" id="password"/>
        <button ng-click="login()"><div class="label">Connexion</div><div class="spinner"></div></button>
    </form>

    <?php
    require_once('views/elements/user.php');
    ?>    
</body>

</html>
