<script>
    var listeAjout = new Array();
    var listeSupp = new Array();

    //Fonction qui ajoute à la liste déroulante les options de complétion
    function suggestion(str) {
        const listSugg = document.getElementById("suggestion");
        if (str == "") {
            var opts = select.getElementsByTagName('option');
            for(var i = 0; i < opts.length; ){
                listSugg.removeChild(opts[i]);
            }
            return;
        }
        else {
            if (window.XMLHttpRequest) {
                // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {
                // code pour les navigateurs IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                var optionListe='';
                var liste = this.responseText.split("\n");
                for (var i=0; i < liste.length;++i){
                    optionListe += "<option value=\""+liste[i]+"\" />\n"; // Stockage des options dans une variable
                }
                listSugg.innerHTML = optionListe;
            };
            xmlhttp.open("GET","getIng.php?ing="+str,true);
            xmlhttp.send();

        }
    }

    //Fonction qui retire un ingredient de la recherche d'ajout ainsi que son bouton
    function deleteIngAjout(str){
        listeAjout.splice(listeAjout.indexOf(str), 1);
        afficheRecette("");
        var btn = document.getElementById(str);
        btn.remove();
    }

    //Fonction qui retire un ingredient de la recherche de suppression ainsi que son bouton
    function deleteIngSupp(str){
        listeSupp.splice(listeSupp.indexOf(str), 1);
        afficheRecette("");
        var btn = document.getElementById(str);
        btn.remove();
    }

    //Focntion qui ajoute un ingrédient à la recherche d'ajout et crée son bouton
    function ajoutIng(str) {
        if(listeAjout.indexOf(str) == -1) {
            /*Ajout de l'ingrédient à la liste des ajouts*/
            listeAjout.push(str);

            /*Création du bouton*/
            var form = document.getElementById('boutonsAjouts');
            var btn = document.createElement("BUTTON");
            btn.setAttribute("id", str);

            btn.setAttribute("class", "btnAjout");
            btn.setAttribute("onclick", "deleteIngAjout(this.id)");
            btn.innerHTML = "<span>"+str+"</span>";
            form.insertBefore(btn, null);
        }
    }

    //Focntion qui ajoute un ingrédient à la recherche de suppression et crée son bouton
    function suppressionIng(str) {
        /*Ajout de l'ingrédient à la liste des suppressions*/
        if(listeSupp.indexOf(str) == -1) {
            listeSupp.push(str);

            /*Création du bouton*/
            var form = document.getElementById('boutonsSuppressions');
            var btn = document.createElement("BUTTON");

            btn.setAttribute("id", str);
            btn.setAttribute("class", "btnSupp");
            btn.setAttribute("onclick", "deleteIngSupp(this.id)");
            btn.innerHTML = "<span>"+str+"</span>";

            form.insertBefore(btn, null);
        }
    }




    //Affiche les recettes en fonction des différentes listes de recherche
    function afficheRecette(cond) {
        if (cond == 'ajout') {
            ajoutIng(document.getElementById('ingVoulu').value);
        } else if (cond == 'supp') {
            suppressionIng(document.getElementById('ingNonVoulu').value);
        }

        var str = "";
        var div = document.getElementById('listeCocktails');

        /*On supprime tous les cocktails qui sont déjà affichés*/
        div.innerHTML = "";

        var cpt = 0;
        var strAjout = "";
        var strSupp = "";

        /*On ajoute tous les ingrédients que l'on veut dans la requête*/
        cpt = 0;
        listeAjout.forEach(element => {
            strAjout += "nomRecette IN (SELECT nomRecette FROM Liaison WHERE nomIngredient = \"" + element + "\")";
            if (cpt < listeAjout.length - 1) {
                strAjout += " AND ";
            }
            cpt += 1;
        });

        /*On ajoute tous les ingrédients que l'on ne veut pas dans la requête*/
        cpt = 0;
        listeSupp.forEach(element => {
            //str+="["+element;
            strSupp += "nomRecette NOT IN (SELECT nomRecette FROM Liaison WHERE nomIngredient = \"" + element + "\")";
            if (cpt < listeSupp.length - 1) {
                strSupp += " AND ";
            }
            cpt += 1;
        });

        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var element = document.createElement("p");

        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                var liste = this.responseText.split("\n");
                element.innerHTML = innerHTMLRecette(liste);
                div.insertBefore(element, null);
            }
        };

        if (strAjout != "") {
            str += "(" + strAjout + ")";
            if (strSupp != "") {
                str += " AND (" + strSupp + ")";
            }
        } else {
            if (strSupp != "") {
                str += strSupp;
            }
        }
        xmlhttp.open("GET", "getRecette.php?ing=" + str, false);
        xmlhttp.send();
    }

    //Retourne le corps HTML du paragraphe des recettes
    function innerHTMLRecette(liste){
        var listeRecettes = String(liste).split("_");
        var strP = "<br><br>";
        var innerListe;
        for(var j=0; j<listeRecettes.length-1; j++) {
            innerListe = listeRecettes[j].split(",");
            strP += "<strong>Recette</strong> : " + innerListe[0] + "<br>Ingredients : ";
            for (var i = 1; i < innerListe.length; ++i) {
                strP += innerListe[i];
                if (i < innerListe.length - 2) {
                    strP += ", ";
                }
            }
            strP += "<br>";
        }
        return strP;
    }
</script>