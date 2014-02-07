<template class="panes step-1">
    <div class="bienvenue">
        <div>
            <h1>Bienvenue à l'ISEN.</h1>
            <p>Avant de visionner les documents de rentrée, veuillez entrer vos informations de contact.</p>
        </div>
    </div>
    <div class="contact">
        <form>
            <h2>Informations de contact :</h2>

            <h3>Vous :</h3>

            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" ng-model="eleve.nom"/>
            <label for="email">Adresse E-mail :</label>
            <input type="email" name="email" id="email" ng-model="eleve.email"/>
            <label for="ddn">Date de naissance :</label>
            <input type="text" name="ddn" id="ddn" ng-model="eleve.datenaissance"/>

            <h3>Vos parents :</h3>
            <label for="nom">Nom parent :</label>
            <input type="text" name="nom" id="nom-parents" ng-model="eleve.nomparent"/>
            <label for="email-parents">Adresse E-mail :</label>
            <input type="email" name="email-parents" id="email-parents" ng-model="eleve.emailparent"/>
            <label for="tel-parents">Téléphone mobile :</label>
            <input type="text" name="tel-parents" id="tel-parents" ng-model="eleve.telparent"/>
            <button ng-click="submit()"><div class="label">Envoyer</div><div class="spinner"></div><div class="success-label">Merci !</button>
        </form>
    </div>
    <div class="promos">
        <h1>Sélectionner votre promotion</h1>
        <ul>
            <!--ng-click permet d'appeler une fonction contenu dans le controller. Les doubles accolades permettent de préciser à Angular qu'il faut interpréter le code-->
            <li ng-click="select(promo.id_promotion)" ng-repeat="promo in promos">{{promo.nompromotion}}</li>
            <!--ng-repeat permet de boucler dans un tableau. Un simple promos.push quelques part dans le code mettra à jour la vue -->
        </ul>
    </div>

    <div class="documents">
        <h1>Sélectionner vos documents</h1>
        <ul>
            <!--ng-if permet de faire du test. Si la condition est vraie, alors l'élément est affiché -->
            <li ng-repeat="document in documents" ng-if="document.id_promotion==selected || selected==0">{{document.nom}}</li>
            <!--Ici, l'élément est affiché si l'ID de promotion de l'élément correspond à la variable $scope.selected. 0 correspond aux documents communs-->
        </ul>
    </div>
    <div class="document-viewer">
    </div>
</template>