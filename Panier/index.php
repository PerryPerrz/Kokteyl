<?php
//On ouvre la bdd.
include_once("../OuvertureBDD/index.php");
//On crée une session ou récupère celle en cours (gestion des cookies de session).
session_start();
//On fait apparaître la structure du haut de la page
include_once("../StructurePage/entete.php");
include_once("../StructurePage/menu.php");
include_once("../AccesHierarchique/fonctionsPanier.php");
?>
<link rel="stylesheet" href="../animBoutons.css">
<div class="w3-main w3-content w3-padding w3-center" style="max-width:1200px;margin-top:100px">
    <h2>Mon panier</h2>
    <button class='glow-on-hover' onclick="viderPanier()">Vider panier</button>
    <ul class="w3-ul">
        <?php
        //On regarde si l'utilisateur est connecté, si il ne l'est pas, on regarde dans les cookies si il à sauvegardé une recette, sinon on regarde dans la bdd.
        if (isset($_SESSION['login'])) {
            $panier = $bdd->prepare("SELECT nomRecette FROM Panier WHERE utilisateur = :utilisateur");
            $panier->bindParam(":utilisateur", $_SESSION['login']);
            $panier->execute();
            while ($cocktail = $panier->fetch()) {
                $nomCocktail = str_replace("'", "'", $cocktail['nomRecette']);
                echo "<li>" . $cocktail['nomRecette'] . "  <img class=\"croix\" src=\"../Ressources/erreur.png\" alt=\"Croix retirant le cocktail du pannier\" onclick=\"suppRecette('" . $_SESSION['login'] . "','" . $nomCocktail . "')\"> </li>";
            }
        } else {
            //Si l'utilisateur à déjà des cocktails dans le panier
            if (isset($_SESSION['panier'])) {
                //On parcourt les recettes enregistrées dans le panier dans les cookies
                foreach ($_SESSION['panier'] as $cocktail => $valeur) { //On parcourt les cookies de panier et on se retrouve avec chaque cocktail et sa valeur (true si dans le panier, false si supprimé).
                    //Si le cocktail n'a pas été enlevé du panier par l'utilisateur on l'affiche
                    if ($valeur) {
                        $nomCocktail = str_replace("'", "'", $cocktail);
                        echo "<li>" . $cocktail . "  <img class=\"croix\" src=\"../Ressources/erreur.png\" alt=\"Croix retirant le cocktail du pannier\" onclick=\"suppCookie('" . $nomCocktail . "')\"> </li>";
                    }
                }
            } else {
                echo "Pas d'article(s) dans le panier pour l'instant, n'hésitez pas !";
            }
        }
        ?>
    </ul>
</div>



<?php
//On fait apparaître la structure du bas de la page
include_once("../StructurePage/piedDePage.php");
?>