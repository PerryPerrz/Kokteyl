<?php
//On ouvre la bdd.
include("../OuvertureBDD/index.php");
//On crée une session ou récupère celle en cours (gestion des cookies de session).
session_start();
//On fait apparaître la structure du haut de la page
include_once("../StructurePage/entete.php");
include_once("../StructurePage/menu.php");
?>

    <h3>Mon Panier</h3>
    <ul>
        <?php
        //On regarde si l'utilisateur est connecté, si il ne l'est pas, on regarde dans les cookies si il à sauvegardé une recette, sinon on regarde dans la bdd.
        if (isset($_SESSION['login'])) {
            $panier = $bdd->prepare("SELECT nomRecette FROM Panier WHERE utilisateur = :utilisateur");
            $panier->bindParam(":utilisateur", $_SESSION['login']);
            $panier->execute();
            while ($cocktail = $panier->fetch()) {
                echo "<li>" . $cocktail['nomRecette'] . "</li>";
            }
        } else {
            //Si l'utilisateur à déjà des cocktails dans le panier
            if (isset($_SESSION['panier'])) {
                //On parcours les recettes enregistrées dans le panier dans les cookies
                foreach ($_SESSION['panier'] as $cocktail => $valeur) { //On parcours les cookies de panier et on se retrouve avec chaque cocktail et sa valeur (1 si pas supprimé, 0 si supprimé).
                    //Si le cocktail n'a pas été enlevé du panier par l'utilisateur on l'affiche
                    if ($valeur == 1) {
                        echo "<li>" . $cocktail . "</li>";
                    }
                }
            } else {
                echo "Pas d'articles dans le panier pour l'instant, n'hésitez pas !";
            }
        }
        ?>
    </ul>



<?php
//On fait apparaître la structure du bas de la page
include_once("../StructurePage/piedDePage.php");
?>