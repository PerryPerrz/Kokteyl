<?php
//On ouvre la bdd.
include("../OuvertureBDD/index.php");
//On crée une session ou récupère celle en cours (gestion des cookies de session).
session_start();

//On déclare les fonctions nécessaires à l'exécution des recherches
include_once("../Recherche/fonctionsRecherche.php");

//On fait apparaître la structure du haut de la page
include_once("../StructurePage/entete.php");
include_once("../StructurePage/menu.php");

?>

<div class="w3-main w3-content w3-padding w3-center" style="max-width:1200px;margin-top:100px">
  <div id="page">
      <h2> Recherche avancée de cocktails</h2>
      <div>
      <div class="formulaires">
        <br>
        <legend for="ingVoulu">Ajoutez les ingrédients que vous souhaitez ajouter dans votre cocktail</legend>
        <input id="ingVoulu" type="search" name="ingVoulu" type="text" list="suggestion" required="required" autocomplete="off" onkeyup="suggestion(this.value)"/>
        <datalist id="suggestion">
        </datalist>
        <button id="validerAjout" name="Valider" onclick="afficheRecette('ajout')">Valider</button>
        <div id="boutonsAjouts"></div>
      </div>
    </div>
    <div>
      <div>
        <br>
        <legend for="ingNonVoulu">Ajoutez les ingrédients que vous souhaitez enlever de votre cocktail</legend>
        <input id="ingNonVoulu" type="search" name="ingNonVoulu" type="text" list="suggestion" required="required" autocomplete="off" onkeyup="suggestion(this.value)"/>
        <datalist id="suggestion">
        </datalist>
        <button id="validerAjout" name="Valider" onclick="afficheRecette('supp')">Valider</button>
        <div id="boutonsSuppressions"></div>
      </div>
    </div>
      <div>
          <div id="listeCocktails"></div>
          <br>
      </div>
    </div>
  </div>
</div>

<?php
//On fait apparaître la structure du bas de la page
include_once("../StructurePage/piedDePage.php");
?>