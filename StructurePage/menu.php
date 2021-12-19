<!-- Fichier servant à factoriser le code que l'on réutilise dans tous les pages, il suffit de l'include pour éviter la duplication de code. -->
<!-- Ce code est présent dans toutes les pages à l'exception de l'acceuil car les liens utilisés ne sont pas les mêmes. -->
<!-- Fichier correspondant au menu du site -->

<!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left"
     style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
    <a onclick="location.href='../'" class="w3-bar-item w3-button">Accueil</a>
    <a onclick="location.href='../Inscription/'" class="w3-bar-item w3-button">Inscription</a>
    <a onclick="location.href='../Connexion/'" class="w3-bar-item w3-button">Connexion</a>
    <a onclick="location.href='../Deconnexion/'" class="w3-bar-item w3-button">Deconnexion</a>
</nav>

<!-- Top menu -->
<div class="w3-top">
    <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
        <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
        <div class="w3-right w3-padding-16">"Cart"</div>
        <div class="w3-center w3-padding-16">Kokteyl</div>
    </div>
</div>

<script>
    // Script to open and close sidebar
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
    }
</script>