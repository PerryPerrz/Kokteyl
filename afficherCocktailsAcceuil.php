<?php
//Fonction permettant de réduire la duplication de code
function afficherCocktails(bool|array $cocktails, int $i, string $cheminImage): array
{
    //On ne parcourt pas les élements vides de l'Array
    if (!empty($cocktails[$i])) {
        $nomCocktail = $cocktails[$i]['nom'];
        $nomImage = formatageString($cocktails[$i]['nom']);
        $nomFinal = $cheminImage . $nomImage . ".jpg";
        ?>
        <div class="w3-quarter">
            <div class="img w3-hover-opacity">
                <?php
                include_once("fonctionsJS/fonctionsPanier.php");

                //Si le cocktail à une image, on l'affiche sinon on affiche une image par défaut
                if (file_exists($nomFinal)) {
                    echo "<img style=\"width:100%;max-width:400px\" src=\"" . $nomFinal . "\" alt=\"" . $nomCocktail . "\" class = \"images\" onclick=\"";
                } else {
                    echo "<img style=\"width:100%;max-width:400px\" src=\"../Ressources/defaultboisson.png\" alt=\"Image à clicker pour ajouter l'article " . $nomCocktail . " au panier\" class = \"images\" onclick=\"";
                }

                //Si le cocktail contient le caractère spécial ' non échappé, on l'échappe
                //$nomCocktail = str_replace("'", "\'", $cocktails[$i]['nom']);

                //On vérifie si la recette est dans le panier de l'utilisateur, si oui un click sur l'image l'enlève, si non, un click sur l'image l'ajoute.
                //Si l'utilisateur est connecté
                if (isset($_SESSION['login'])) {

                    $estDansPanier = false;
                    //On parcours le panier de l'utilisateur pour savoir si le cocktail est dedans
                    $panier = $bdd->prepare("SELECT nomRecette FROM Panier WHERE utilisateur = :utilisateur");
                    $panier->bindParam(":utilisateur", $_SESSION['login']);
                    $panier->execute();
                    while ($cocktail = $panier->fetch()) {
                        if ($cocktail['nomRecette'] == $nomCocktail)
                            $estDansPanier = true;
                    }

                    $nomCocktail = str_replace("'", "\'", $nomCocktail);
                    //Si le cocktail est dans le panier on propose de le supprimer et inversement sinon
                    if ($estDansPanier) {
                        echo "suppRecette('" . $_SESSION['login'] . "','" . $nomCocktail . "')";
                    } else {
                        echo "ajoutRecette('" . $_SESSION['login'] . "','" . $nomCocktail . "')";
                    }
                } else { //Si l'utilisateur n'est pas connecté
                    //Si l'utilisateur à déjà ajouté ou supprimé le cocktail au panier
                    if (isset($_SESSION['panier'][$nomCocktail])) {
                        //Si il est actuellement ajouté au panier on le supprime lors d'un click sur l'image
                        if ($_SESSION['panier'][$nomCocktail]) {
                            $nomCocktail = str_replace("'", "\'", $nomCocktail);
                            echo "suppCookie('" . $nomCocktail . "')";
                        } else { //Si il n'est pas dans le panier on l'ajoute lors d'un click sur l'image
                            $nomCocktail = str_replace("'", "\'", $nomCocktail);
                            echo "addCookie('" . $nomCocktail . "')";
                        }
                    } else { //Sinon, on ajoute le cocktail au panier lors d'un click sur l'image
                        $nomCocktail = str_replace("'", "\'", $nomCocktail);
                        echo "addCookie('" . $nomCocktail . "')";
                    }
                }
                $nomBis = str_replace("'", "-_-",$cocktails[$i]['nom']);
                ?>
                ">
            </div>
            <a href='VisualisationRecette/index.php?cocktail=<?= $nomBis ?>'><h3> <?= $cocktails[$i]['nom'] ?></h3></a>
        </div>
    <?php }
    return array($cocktails, $nomImage, $nomFinal);
}