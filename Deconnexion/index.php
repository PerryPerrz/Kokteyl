<?php
// Démarrage ou restauration de la session
session_start();
// Réinitialisation du tableau de session
// On le vide intégralement
$_SESSION = array();
// Destruction de la session
session_destroy();
// Destruction du tableau de session
unset($_SESSION);
//On fait apparaître la structure du haut de la page
include_once("../StructurePage/entete.php");
include_once("../StructurePage/menu.php");
?>

<div id="wrapper">
    <div id="staff" class="container">
        <div class="title">
            <h2>Déconnexion</h2>
            <p>Vous êtes bien déconnecté. Pour revenir à la page d'accueil <a href="../">Cliquez ici</a></p> </div>
    </div>
</div>

<?php
//On fait apparaître la structure du bas de la page
include_once("../StructurePage/piedDePage.php");
?>