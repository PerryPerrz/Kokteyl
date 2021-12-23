<?php
//On ouvre la bdd.
include_once ("OuvertureBDD/index.php");
include_once ("StructurePage/nbCocktailsPanier.php");
//On crée une session ou récupère celle en cours (gestion des cookies de session).
session_start();
?>
<!DOCTYPE html>
<html>
<title>Kokteyl</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="font.css">
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Karma", sans-serif
    }

    .w3-bar-block .w3-bar-item {
        padding: 20px
    }
</style>

<body>

<!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left"
     style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
    <a href="#drink" onclick="w3_close()" class="w3-bar-item w3-button">Drinks</a>
    <a onclick="location.href='AccesHierarchique/'" class="w3-bar-item w3-button">Accéder aux cocktails</a>
    <?php if (isset($_SESSION['login'])) { ?>
        <a onclick="location.href='Compte/'" class="w3-bar-item w3-button">Mon Compte</a>
        <a onclick="location.href='Deconnexion/'" class="w3-bar-item w3-button">Deconnexion</a>
    <?php } else { ?>
        <a onclick="location.href='Inscription/'" class="w3-bar-item w3-button">Inscription</a>
        <a onclick="location.href='Connexion/'" class="w3-bar-item w3-button">Connexion</a>
    <?php } ?>
    <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
</nav>

<!-- Top menu -->
<div class="w3-top">
    <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
        <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
        <div class="w3-right w3-padding-16 w3-shake"><a id="caddie" href="Panier/"><img src="Ressources/caddie<?=nbCocktailsPanier()?>.png"/></a></div>
        <div class="w3-center w3-padding-16"><a id="logo" href="#"><img src="Ressources/logoKok.png"/></a></div>
    </div>
</div>

<!-- On prépare la pagination utile à l'affichage des cocktails. -->
<?php

include_once ("StructurePage/formatageString.php");

// On détermine sur quelle page on se trouve
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int)strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}

//On affiche seulement les cocktails avec des photos
$cocktailsAvecPhotos = "'Black velvet','Bloody Mary','Bora bora','Builder','Caïpirinha','Coconut kiss','Cuba libre','Frosty lime','Le vandetta','Margarita','Mojito','Piña colada','Raifortissimo','Sangria sans alcool','Screwdriver','Shoot up','Tequila sunrise','Ti\'punch'";
$query = "SELECT COUNT(*) AS nbCocktails FROM Recettes WHERE nom IN (" . $cocktailsAvecPhotos . ");"; //On créer la requête qui compte le nombre de cokctails.
$query2 = $bdd->prepare($query); //On prépare son exécution dans la base de données.

// On exécute la requête
$query2->execute();

// On récupère le nombre de cocktails
$resultQuery = $query2->fetch();

$nbCocktails = (int)$resultQuery['nbCocktails'];
// On détermine le nombre de cocktails par page
$parPage = 8;

// On calcule le nombre de pages total
$nbPages = ceil($nbCocktails / $parPage);

// Calcul du 1er cocktail de la page
$premier = ($currentPage * $parPage) - $parPage;

//Requête qui récupère les 8 cocktails par page.
$query = "SELECT * FROM Recettes WHERE nom IN (" . $cocktailsAvecPhotos . ") ORDER BY nom LIMIT :premier, :parpage;";

// On prépare la requête
$query2 = $bdd->prepare($query);

$query2->bindValue(':premier', $premier, PDO::PARAM_INT);
$query2->bindValue(':parpage', $parPage, PDO::PARAM_INT);

// On exécute
$query2->execute();

// On récupère les données dans un tableau
$cocktails = $query2->fetchAll(PDO::FETCH_ASSOC);

$cheminImage = "Photos/";

include_once("afficherCocktailsAcceuil.php");
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

    <!-- First Photo Grid-->
    <div class="w3-row-padding w3-padding-16 w3-center" id="drink">

        <?php
        for ($i = 0; $i < $parPage / 2; ++$i) {
            //On éxecute la fonction permettant d'afficher les images des cocktails de la première ligne
            list($cocktails, $nomImage, $nomFinal) = afficherCocktails($cocktails, $i, $cheminImage);
        }
        ?>
    </div>

    <!-- Second Photo Grid-->
    <div class="w3-row-padding w3-padding-16 w3-center">
        <?php
        for ($i = $parPage / 2; $i < $parPage; ++$i) {
            //On éxecute la fonction permettant d'afficher les images des cocktails de la première ligne
            list($cocktails, $nomImage, $nomFinal) = afficherCocktails($cocktails, $i, $cheminImage);
        }
        ?>
    </div>

    <!-- Pagination -->
    <?php
        //On affiche et mets en place la pagination
        include_once ("StructurePage/pagination.php");
    ?>
    <hr id="about">

    <!-- About Section -->
    <div class="w3-container w3-padding-32 w3-center">
        <h3>About Me, The drink Man</h3><br>
        <img src="/w3images/chef.jpg" alt="Me" class="w3-image" style="display:block;margin:auto" width="800"
             height="533">
        <div class="w3-padding-32">
            <h4><b>I am Who I Am!</b></h4>
            <h6><i>With Passion For Real, Good drink</i></h6>
            <p>Just me, myself and I, exploring the universe of unknownment. I have a heart of love and an interest of
                lorem ipsum and mauris neque quam blog. I want to share my world with you. Praesent tincidunt sed tellus
                ut rutrum. Sed vitae justo
                condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla. Praesent tincidunt sed
                tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non
                fringilla.</p>
        </div>
    </div>
    <hr>

    <!-- Footer -->
    <footer class="w3-row-padding w3-padding-32">
        <div class="w3-third">
            <h3>FOOTER</h3>
            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies
                congue gravida diam non fringilla.</p>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>

        <div class="w3-third">
            <h3>BLOG POSTS</h3>
            <ul class="w3-ul w3-hoverable">
                <li class="w3-padding-16">
                    <img src="/w3images/workshop.jpg" class="w3-left w3-margin-right" style="width:50px">
                    <span class="w3-large">Lorem</span><br>
                    <span>Sed mattis nunc</span>
                </li>
                <li class="w3-padding-16">
                    <img src="/w3images/gondol.jpg" class="w3-left w3-margin-right" style="width:50px">
                    <span class="w3-large">Ipsum</span><br>
                    <span>Praes tinci sed</span>
                </li>
            </ul>
        </div>

        <div class="w3-third w3-serif">
            <h3>POPULAR TAGS</h3>
            <p>
                <span class="w3-tag w3-black w3-margin-bottom">Travel</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">New York</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Dinner</span>
                <span class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Salmon</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">France</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Drinks</span>
                <span class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Ideas</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Flavors</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Cuisine</span>
                <span class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Chicken</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Dressing</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Fried</span>
                <span class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Fish</span> <span
                        class="w3-tag w3-dark-grey w3-small w3-margin-bottom">Duck</span>
            </p>
        </div>
    </footer>

    <!-- End page content -->

    <script>
        // Script to open and close sidebar
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>

</div>

</body>

</html>