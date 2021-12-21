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
        xmlhttp.open("GET", "../AccesHierarchique/addCocktail.php?p=" + str, true);
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
        xmlhttp.open("GET", "../AccesHierarchique/suppCocktail.php?p=" + str, false);
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
        xmlhttp.open("GET", "../AccesHierarchique/addCookie.php?p=" + recette, true);
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
        xmlhttp.open("GET", "../AccesHierarchique/suppCookie.php?p=" + recette, true);
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
        xmlhttp.open("GET", "../AccesHierarchique/sousCat.php?p=" + superCat, true);
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
        xmlhttp.open("GET", "../AccesHierarchique/backLead.php?p=" + categorie, true);
        xmlhttp.send();
    }

    function viderPanier() {

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
        xmlhttp.open("GET", "../AccesHierarchique/viderPanier.php", true);
        xmlhttp.send();
    }
</script>