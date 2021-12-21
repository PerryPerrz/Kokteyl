<?php
//On ouvre la bdd.
include("../OuvertureBDD/index.php");
//On crée une session ou récupère celle en cours (gestion des cookies de session).
session_start();
//On fait apparaître la structure du haut de la page
include_once("../StructurePage/entete.php");
include_once("../StructurePage/menu.php");
?>

<script>
    //Fonction permettant d'ajouter une recette au panier quand l'utilisateur est connecté
    function ajoutRecette(user, recette) {
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var str = user + "|" + recette;
        xmlhttp.onreadystatechange = function() {
            if (!this.readyState == 4) { //Si l'appel n'est pas terminé
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET", "addCocktail.php?p=" + str, true);
        xmlhttp.send();
    }

    //Fonction permettant de supprimer une recette du panier quand l'utilisateur est connecté
    function suppRecette(user, recette) {
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var str = user + "|" + recette;
        xmlhttp.onreadystatechange = function() {
            if (!this.readyState == 4) { //Si l'appel n'est pas terminé
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET", "suppCocktail.php?p=" + str, false);
        xmlhttp.send();
    }

    //Fonction permettant d'ajouter une recette au panier quand l'utilisateur n'est pas connecté
    function addCookie(recette) {
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (!this.readyState == 4) { //Si l'appel n'est pas terminé
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET", "addCookie.php?p=" + recette, true);
        xmlhttp.send();
    }


    //Fonction permettant de supprimer une recette du panier quand l'utilisateur n'est pas connecté
    function suppCookie(recette) {
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (!this.readyState == 4) { //Si l'appel n'est pas terminé
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET", "suppCookie.php?p=" + recette, true);
        xmlhttp.send();
    }

    //Fonction qui change la catégorie courante par celle donnée en paramètre et enregistre le chemin parcourue jusque celle ci dans $_SESSION
    function sousCat(superCat) {

        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                document.location.href = "./";
            } else {
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET", "sousCat.php?p=" + superCat, true);
        xmlhttp.send();
    }

    function backLead(categorie) {

        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                document.location.href = "./";
            } else {
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET", "backLead.php?p=" + categorie, true);
        xmlhttp.send();

    }
</script>
<div id="header-wrapper">
    <?php
    //On affiche le bouton déconnexion si l'utilisateur est connecté
    if (isset($_SESSION['login'])) {
    ?>
        <button onclick="location.href='../Deconnexion/'" class="button" style=vertical-align:middle>Déconnexion
        </button>
    <?php
    } //On affiche le bouton connexion si l'utilisateur n'est pas connecté
    else {
    ?>
        <button onclick="window.location.href = '../ConnexionSite/';" class="button" style=vertical-align:middle>
            Connexion
        </button>
    <?php } ?>

    <!--Bandeau de navigation-->
    <div id="header" class="container">
        <div id="logo">
            <h1><a href="../">Kakuteru</a></h1>
        </div>
        <div id="menu">
            <ul>
                <li class="active"><a href="../" accesskey="1" title="">Accueil</a></li>
                <li><a href="#" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="../Recettes/" accesskey="3" title="">Nos recettes</a></li>
                <!--On affiche l'onglet mon compte si l'utilisateur est connecté-->
                <?php if (isset($_SESSION['login'])) { ?>
                    <li><a href="../Compte/" accesskey="4" title="">Mon compte</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<div id="wrapper">
    <div id="staff" class="container">
        <div class="title">
            <h2>Nos cocktails</h2>
            <span> Voici la liste de nos différents cocktails (disponible dès à présent sur le KakuteruStore)</span>
        </div>

        <?php
        function connexion()
        {
            try {
                // On se connecte à MySQL
                $bdd = new PDO('mysql:host=localhost;dbname=Kokteyl;charset=utf8', 'root', '');
                return $bdd;
            } catch (Exception $e) {
                // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : ' . $e->getMessage());
            }
        }

        function sousCategorie($categorie)
        {
            if (!str_contains($categorie, "\'")) {
                $nomBis = str_replace("'", "\'", $categorie);
            }
            $sql = "SELECT nom FROM SuperCategorie WHERE nomSuper = '" . $nomBis . "'";
            $bdd = connexion();
            $req = $bdd->query($sql);
            while ($donnees = $req->fetch()) {
                if (!str_contains($donnees['nom'], "\'")) {
                    $nomCat = str_replace("'", "\'", $donnees['nom']);
                }
                $sql .= " OR nom IN (" . sousCategorie($nomCat) . ")";
            }
            return $sql;
        }

        //Fonction qui remplace les accents, les espaces et les apostrophes d'un string utilse pour charger les images à partir du nom des cocktails.
        function formatageString($str)
        {
            $strSansAcc = $str; //Lettre sans accent
            $strSansAcc = preg_replace('#Ç#', 'C', $strSansAcc);
            $strSansAcc = preg_replace('#ç#', 'c', $strSansAcc);
            $strSansAcc = preg_replace('#è|é|ê|ë#', 'e', $strSansAcc);
            $strSansAcc = preg_replace('#È|É|Ê|Ë#', 'E', $strSansAcc);
            $strSansAcc = preg_replace('#à|á|â|ã|ä|å#', 'a', $strSansAcc);
            $strSansAcc = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $strSansAcc);
            $strSansAcc = preg_replace('#ì|í|î|ï#', 'i', $strSansAcc);
            $strSansAcc = preg_replace('#Ì|Í|Î|Ï#', 'I', $strSansAcc);
            $strSansAcc = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $strSansAcc);
            $strSansAcc = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $strSansAcc);
            $strSansAcc = preg_replace('#ù|ú|û|ü#', 'u', $strSansAcc);
            $strSansAcc = preg_replace('#Ù|Ú|Û|Ü#', 'U', $strSansAcc);
            $strSansAcc = preg_replace('#ý|ÿ#', 'y', $strSansAcc);
            $strSansAcc = preg_replace('#Ý#', 'Y', $strSansAcc);
            $strSansAcc = preg_replace('#ñ#', 'n', $strSansAcc);

            $sansEspaces = str_replace(' ', '_', $strSansAcc);
            $sansAppostrophe = str_replace("'", '', $sansEspaces);

            //On veut le string au format : première lettre est une majuscule, tout le reste est en minuscule (pour un affichage PROPRE)
            $lettreEnMaj = substr($sansAppostrophe, 0, 1); //On récup la première lettre
            $suiteDeMot = strtolower(substr($sansAppostrophe, 1));

            return ($lettreEnMaj . $suiteDeMot);
        }

        ?>

        <h2>Choisissez un filtre pour vos boisson</h2><br>
        <div>
            <?php
            //On affiche toutes les catégories possibles de sélectionner

            //Si c'est le premier chargement la catégorie courante est Aliment
            if (!isset($_SESSION['categorieCourante'])) {
                $_SESSION['categorieCourante'] = 'Aliment';
                $_SESSION['supCategorie']['Aliment'] = 1;
                $superCat = $bdd->query("SELECT DISTINCT nom FROM SuperCategorie WHERE nomSuper = 'Aliment'");
                while ($donnees = $superCat->fetch()) {
                    $nomCat = $donnees['nom'];
                    $nomCat = str_replace("'", "\'", $nomCat);
                    echo "<button class='boutonCat' onclick=\"sousCat('" . $nomCat . "')\">" . $donnees['nom'] . "</button>";
                }
            ?>
        </div><br>
    <?php
            }
            //Sinon on prend la catégorie courante enregistrée
            else {
                if (isset($_SESSION['supCategorie'])) {
                    foreach ($_SESSION['supCategorie'] as $cat => $val) {
                        if ($cat != 'Aliment' && $val == 1) {
                            $cat = str_replace("'", "\'", $cat);
                            $nomAffichage = str_replace("\'", "'", $cat);
                            echo "<button class='boutonCat' onclick=\"backLead('$cat')\">$nomAffichage</button><br><br>";
                        }
                    }
                }
                $superCat = $bdd->prepare("SELECT DISTINCT nom FROM SuperCategorie WHERE nomSuper = :super");
                $superCat->bindParam(":super", $_SESSION['categorieCourante']);
                $superCat->execute();
                while ($donnees = $superCat->fetch()) {
                    $nomCat = $donnees['nom'];
                    $nomCat = str_replace("'", "\'", $nomCat);
                    echo "<button class='boutonCat' onclick=\"sousCat('" . $nomCat . "')\">" . $donnees['nom'] . "</button>";
                }
    ?>
    </div>
    <br>
    <?php
            }

            // On détermine sur quelle page on se trouve
            if (isset($_GET['page']) && !empty($_GET['page'])) {
                $currentPage = (int)strip_tags($_GET['page']);
            } else {
                $currentPage = 1;
            }

            //On donne le chemin des images nécessaire à l'affichage des images des cocktails
            $cheminImage = "../Photos/";
            $nomCat = str_replace("'", "\'", $_SESSION['categorieCourante']);
            $queryNbCocktails = $bdd->query("SELECT COUNT(DISTINCT nom) AS nbCocktails FROM Recettes JOIN Liaison ON Liaison.nomRecette = Recettes.nom WHERE nomIngredient = '" . $nomCat . "' OR  nomIngredient IN (" . sousCategorie($_SESSION['categorieCourante']) . ")");
            if ($resultQuery = $queryNbCocktails->fetch()) {
                //On récupère le nombre de cocktails et fait nos calculs pour les afficher correctement avec la pagination

                //On récupère le nombre de cocktails
                $nbCocktails = (int)$resultQuery['nbCocktails'];

                // On détermine le nombre de cocktails par page
                $parPage = 8;

                // On calcule le nombre de pages total
                $nbPages = ceil($nbCocktails / $parPage);

                // Calcul du 1er cocktail de la page
                $premier = ($currentPage * $parPage) - $parPage;

                //On récupère les cocktails à afficher pour cette page
                $queryCocktails = $bdd->query("SELECT DISTINCT nom FROM Recettes JOIN Liaison ON Liaison.nomRecette = Recettes.nom WHERE nomIngredient = '" . $nomCat . "' OR  nomIngredient IN (" . sousCategorie($_SESSION['categorieCourante']) . ")");
                if ($resultQuery2 = $queryCocktails->fetchAll()) {
                    //On récupère tous les cocktails à afficher sous un format utilisable en sql
                    $listeStrCocktails = "";
                    for ($i = 0; $i < sizeof($resultQuery2); $i++) {
                        $temp = str_replace("'", "\'", $resultQuery2[$i]['nom']);
                        $listeStrCocktails .= "'" . $temp . "',";
                    }
                    $listeStrCocktails = rtrim($listeStrCocktails, ","); //On enlève la dernière virgule
                    $queryCocktails2 = $bdd->prepare("SELECT * FROM Recettes WHERE nom IN (" . $listeStrCocktails . ") ORDER BY nom LIMIT :premier, :parpage;");
                    $queryCocktails2->bindValue(':premier', $premier, PDO::PARAM_INT);
                    $queryCocktails2->bindValue(':parpage', $parPage, PDO::PARAM_INT);

                    // On exécute la requète
                    $queryCocktails2->execute();
                    $cocktails = $queryCocktails2->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <!-- !PAGE CONTENT! -->
        <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

            <!-- First Photo Grid-->
            <div class="w3-row-padding w3-padding-16 w3-center" id="drink">

                <?php
                    for ($i = 0; $i < $parPage / 2; ++$i) {
                        //On ne parcourt pas les élements vides de l'Array
                        if (!empty($cocktails[$i])) {
                            $nomImage = formatageString($cocktails[$i]['nom']);
                            $nomFinal = $cheminImage . $nomImage . ".jpg";
                ?>
                        <div class="w3-quarter">
                            <div class="img">
                                <?php
                                    $nomCocktail = $cocktails[$i]['nom'];
                                    echo $nomCocktail;

                                    //Si le cocktail à une image, on l'affiche sinon on affiche une image par défaut
                                    if (file_exists($nomFinal)) {
                                        echo "<img src=\"" . $nomFinal . "\" alt=\"" . $nomCocktail . "\" class = \"images\" onclick=\"";
                                    } else {
                                        echo "<img src=\"../Ressources/defaultboisson.png\" alt=\"Image à clicker pour ajouter l'article ". $nomCocktail ." au panier\" class = \"images\" onclick=\"";
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
                                            echo "suppRecette('". $_SESSION['login']."','". $nomCocktail ."')";
                                        } else {
                                            echo "ajoutRecette('". $_SESSION['login']."','". $nomCocktail ."')";
                                        }
                                    } else { //Si l'utilisateur n'est pas connecté
                                        //Si l'utilisateur à déjà ajouté ou supprimé le cocktail au panier
                                        if(isset($_SESSION['panier'][$nomCocktail])) {
                                            //Si il est actuellement ajouté au panier on le supprime lors d'un click sur l'image
                                            if ($_SESSION['panier'][$nomCocktail]) {
                                                $nomCocktail = str_replace("'", "\'", $nomCocktail);
                                                echo "suppCookie('". $nomCocktail."')";
                                            } else { //Si il n'est pas dans le panier on l'ajoute lors d'un click sur l'image
                                                $nomCocktail = str_replace("'", "\'", $nomCocktail);
                                                echo "addCookie('". $nomCocktail."')";
                                            }
                                        } else { //Sinon, on ajoute le cocktail au panier lors d'un click sur l'image
                                            $nomCocktail = str_replace("'", "\'", $nomCocktail);
                                            echo "addCookie('". $nomCocktail."')";
                                        }
                                    }
                                ?>
                                        ">
                            </div>
                            <h3> <?= $cocktails[$i]['nom'] ?></h3>
                            <p>Ingrédients
                                : <?= str_replace("|", ", ", $cocktails[$i]['ingredients']) //On remplace les | dans la description par des , pour rendre la description plus lisible  
                                    ?></p>
                            <p>Préparation : <?= $cocktails[$i]['preparation'] ?></p>
                        </div>
                <?php }
                    }
                ?>
            </div>

            <!-- Second Photo Grid-->
            <div class="w3-row-padding w3-padding-16 w3-center">
                <?php

                    for ($i = $parPage / 2; $i < $parPage; ++$i) {
                        //On ne parcourt pas les élements vides de l'Array
                        if (!empty($cocktails[$i])) {
                            $nomImage = formatageString($cocktails[$i]['nom']);
                            $nomFinal = $cheminImage . $nomImage . ".jpg";
                ?>
                        <div class="w3-quarter">
                            <div class="img">
                                <?php
                                //Si le cocktail à une image, on l'affiche sinon on affiche une image par défaut
                                if (file_exists($nomFinal)) {
                                    echo "<img src=\"" . $nomFinal . "\" alt=\"" . $cocktails[$i]['nom'] . "\" class = \"images\" onclick=\"";
                                } else {
                                    echo "<img src=\"../Ressources/defaultboisson.png\" alt=\"Image à clicker pour ajouter l'article ". $cocktails[$i]['nom'] ." au panier\" class = \"images\" onclick=\"";
                                }

                                //On vérifie si la recette est dans le panier de l'utilisateur, si oui un click sur l'image l'enlève, si non, un click sur l'image l'ajoute.
                                //Si l'utilisateur est connecté
                                if (isset($_SESSION['login'])) {
                                    $estDansPanier = false;
                                    //On parcours le panier de l'utilisateur pour savoir si le cocktail est dedans
                                    $panier = $bdd->prepare("SELECT nomRecette FROM Panier WHERE utilisateur = :utilisateur");
                                    $panier->bindParam(":utilisateur", $_SESSION['login']);
                                    $panier->execute();
                                    while ($cocktail = $panier->fetch()) {
                                        if ($cocktail['nomRecette'] == $cocktails[$i]['nom'])
                                            $estDansPanier = true;
                                    }
                                    //Si le cocktail est dans le panier on propose de le supprimer et inversement sinon
                                    if ($estDansPanier) {
                                        echo "suppRecette('". $_SESSION['login']."','". $cocktails[$i]['nom']."')";
                                    } else {
                                        echo "ajoutRecette('". $_SESSION['login']."','". $cocktails[$i]['nom']."')";
                                    }
                                } else { //Si l'utilisateur n'est pas connecté
                                    //Si l'utilisateur à déjà ajouté ou supprimé le cocktail au panier
                                    if(isset($_SESSION['panier'][$cocktails[$i]['nom']])) {
                                        //Si il est actuellement ajouté au panier on le supprime lors d'un click sur l'image
                                        if ($_SESSION['panier'][$cocktails[$i]['nom']] == true) {
                                            echo "suppCookie('". $cocktails[$i]['nom']."')";
                                        } else { //Si il n'est pas dans le panier on l'ajoute lors d'un click sur l'image
                                            echo "addCookie('". $cocktails[$i]['nom']."')";
                                        }
                                    } else { //Sinon, on ajoute le cocktail au panier lors d'un click sur l'image
                                        echo "addCookie('". $cocktails[$i]['nom']."')";
                                    }
                                }
                                ?>
                                        ">
                            </div>
                            <h3> <?= $cocktails[$i]['nom'] ?></h3>
                            <p>Ingrédients
                                : <?= str_replace("|", ", ", $cocktails[$i]['ingredients']) //On remplace les | dans la description par des , pour rendre la description plus lisible  
                                    ?></p>
                            <p>Préparation : <?= $cocktails[$i]['preparation'] ?></p>
                        </div>

                <?php }
                    }
                ?>
            </div>
            <!-- Pagination -->
            <div class="w3-center w3-padding-32">
                <div class="w3-bar">
                    <!-- Lorsque l'on clique sur la flèche précedante, cela ramène l'utilisateur sur la page précedente, si celle-ci n'existe pas, le bouton n'est pas cliquable-->
                    <a href="./?page=<?= $currentPage - 1 ?>" class="w3-bar-item w3-button w3-hover-black <?= ($currentPage == 1) ? "disable" : "" ?>">«</a>

                    <!-- On créer des boutons qui permettent de naviguer entre les pages, si on est sur la page correspondante à un bouton, celui-ci est mis en valeur-->
                    <?php for ($i = 1; $i <= $nbPages; ++$i) {
                    ?>
                        <a href="./?page=<?= $i ?>" class="<?= ($currentPage == $i) ? "w3-bar-item w3-black w3-button" : "w3-bar-item w3-button w3-hover-black" ?>"><?= $i ?></a>
                    <?php } ?>

                    <!-- Lorsque l'on clique sur la flèche suivante, cela ramène l'utilisateur sur la page suivante, si celle-ci n'existe pas, le bouton n'est pas cliquable-->
                    <a href=" ./?page=<?= $currentPage + 1 ?>" class="w3-bar-item w3-button w3-hover-black <?= ($currentPage == $nbPages) ? "disable" : "" ?>">»</a>
                </div>
            </div>
            <hr id="about">

    <?php
                }
            } ?>
        </div>
</div>

<?php
//On fait apparaître la structure du bas de la page
include_once("../StructurePage/piedDePage.php");
?>