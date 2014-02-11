<template class="admin">
    <div class="sidebar">
        <div class="logo-isen" style="font-size: 2Opx">
            <h1>ISEN</h1>
            <h2>documents de rentrée</h2>
        </div>
        <nav>
            <button class="to-documents">Gestion des documents</button>
            <button class="to-eleves">Gestion des élèves</button>
        </nav>
        <button class="logout">Déconnexion</button>
    </div>
    <div class="main">
        <div class="eleves" ngController="AdminElevesCtrl" ngShow="mode == 'eleves'">
            <label for="search">Recherche: </label><input type="search" name="search"/>
            <table>
                <thead><tr>
                        <td>Nom</td>
                        <td>Email</td>
                        <td>Date de naissance</td>
                        <td>Nom parents</td>
                        <td>Email parents</td>
                        <td>Tel. parents</td>
                </tr></thead>
                <tr ng-repeat="eleve in eleves | filter:search | orderBy:'nom'">
                    <td>{{eleve.nom}}</td>
                    <td>{{eleve.email}}</td>
                    <td>{{eleve.ddn}}</td>
                    <td>{{eleve.nomparent}}</td>
                    <td>{{eleve.emailparent}}</td>
                    <td>{{eleve.telparent}}</td>
                </tr>
            </table>
        </div>
        <div class="documents">
            <ul class="promos">
                <li ngRepeat="promo in promos"><label><input type="checkbox" ngChecked="promo.shown">{{promo.nom}} ({{promo.documents.length}} document{{promo.documents.length &gt; 1?"s":""}})</label>
                <ul>
                    <li ngRepeat="document in promo.documents">{{document.nom}}</li>
                </ul>
                </li>
            </ul>
        </div>
    </div>
</template>
