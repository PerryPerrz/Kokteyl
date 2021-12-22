<?php
//On ouvre la bdd.
include("../OuvertureBDD/index.php");
//On crée une session ou récupère celle en cours (gestion des cookies de session).
session_start();
//On fait apparaître la structure du haut de la page
include_once("../StructurePage/entete.php");
include_once("../StructurePage/menu.php");
?>

<div id="wrapper">
    <h2>
        <?php

        //Procédure permettant de factoriser le code.
        //La procédure permet de changer la valeur d'une donnée dans la base de données,
        //la données est rentrée par l'utilisateur lors de la modification des données de son compte.
        function changerDonnee($donnees, $str_donnee_form, $str_donnee_bdd) {
            //On ouvre la bdd et on ouvre la session car la fonction n'est pas appelée au chargement de la page
            //mais quand l'utilisateur appuie sur le bouton enregistrer.
            include ("../OuvertureBDD/index.php");
            session_start();

            // On vérifie que la donnée entrée n'est ni vide, ni la même que celle contenue dans la base de données.
            if ($donnees[$str_donnee_bdd] != $_POST[$str_donnee_form] && !empty($_POST[$str_donnee_form])) {
                //On entre la nouvelle valeur dans la base de données.
                $requete = $bdd->prepare("UPDATE Utilisateur SET " . $str_donnee_bdd ." = :donnee WHERE login = :login");
                $requete->bindParam('login', $_SESSION['login']);
                $requete->bindParam('donnee', $_POST[$str_donnee_form]);
                $requete->execute();
                //On préviens l'utilisateur de la modification de la donnée.
                ?> <p>Modification enregistrée (<?=$str_donnee_form?>).</p><br/><?php
            } else {
                //On prévient l'utilisateur du fait que cette données n'ait pas été modifiée.
                ?> <p>Aucune modification n'a été apportée (<?=$str_donnee_form?>).</p><br/><?php
            }
        }

        $requete = $bdd->prepare("SELECT * FROM Utilisateur WHERE login = :loginSession");
        $loginSession = $_SESSION['login'];
        $requete->bindParam('loginSession', $loginSession);
        $requete->execute();

        if ($donnees = $requete->fetch()) {
            echo "Votre compte : ";
        }
        ?>
    </h2>
    <br><br>
    <div id="page" class="container">
        <div class="boxA">
            <form class="" action="#" method="post">
                <?php
                // On vérifie ici que l'utilisateur a appuyé sur le bouton de validation des changements
                if (isset($_POST["validation"])) {
                    // On vérifie ici que si l'utilisateur rentre un mot de passe, alors tous les champs de mots de passe sont rempli.
                    if (isset($_POST['ancienMdp']) && !empty($_POST["ancienMdp"])) {
                        if (SHA1($_POST["ancienMdp"]) == $donnees['mdp']) {
                            if (isset($_POST['nouveauMdp']) && !empty($_POST["nouveauMdp"]) && $_POST["nouveauMdp"] != $_POST['ancienMdp']) {
                                if (isset($_POST['confirmationMdp']) && !empty($_POST["confirmationMdp"]) && $_POST['nouveauMdp'] == $_POST['confirmationMdp']) {
                                    $requete = $bdd->prepare("UPDATE Utilisateur SET mdp = SHA1(:mdpChanger) WHERE login = :loginSession");
                                    $loginSession = $_SESSION['login'];
                                    $mdpChanger = $_POST['confirmationMdp'];
                                    $requete->bindParam('loginSession', $loginSession);
                                    $requete->bindParam('mdpChanger', $mdpChanger);
                                    $requete->execute();
                                    echo "Nouveau mdp créé";
                                } else {
                                    ?> <em> Mot de passe de confirmation manquant ou différents du nouveau mot de
                                        passe </em> <?php
                                }
                            } else {
                                ?> <em> Nouveau mot de passe manquant ou identique à l'ancien </em> <?php
                            }
                        } else {
                            ?> <em> Mot de passe différent du mot de passe de l'utilisateur </em> <?php
                        }
                    } else {
                        ?><p>Aucune modification n'a été apportée (mot de passe).</p><br><?php
                    }
                    // On fait les différents tests afin de modifier les données de l'utilisateur

                    // On vérifie que le mail entré n'est ni vide, ni le même que celui contenu dans la base de données
                    if ($donnees['login'] != $_POST['email'] && !empty($_POST['email'])) {
                        $requete = $bdd->prepare("UPDATE Utilisateur SET login = :logina WHERE login = :login");
                        $nouveauLogin = $_POST['email'];
                        $requete->bindParam('login', $_SESSION['login']);
                        $requete->bindParam('logina', $nouveauLogin);

                        $requete->execute();
                        $_SESSION['login'] = $nouveauLogin;

                        ?> <p>Modification enregistrée (email).</p><br/><?php
                    } else {
                        ?> <p>Aucune modification n'a été apportée (email).</p><br/><?php
                    }


                    // On change l'adresse dans la base de données si l'utilisateur a essayé de la changer
                    changerDonnee($donnees, 'adresse', 'adresse');

                    // On change le nom dans la base de données si l'utilisateur a essayé de la changer
                    changerDonnee($donnees, 'nom', 'nom');

                    // On change le prénom dans la base de données si l'utilisateur a essayé de la changer
                    changerDonnee($donnees, 'prenom', 'prenom');

                    // On change le code postal dans la base de données si l'utilisateur à essayé de la changer
                    changerDonnee($donnees, 'postal', 'postal');

                    // On change le sexe dans la base de données si l'utilisateur à essayé de la changer
                    changerDonnee($donnees, 'sexe', 'sexe');

                    // On change le numéro de téléphone dans la base de données si l'utilisateur à essayé de la changer
                    changerDonnee($donnees, 'telephone', 'noTelephone');

                    // On change la ville dans la base de données si l'utilisateur à essayé de la changer
                    changerDonnee($donnees, 'ville', 'ville');

                    ?>
                    <button name="retour" action="./">Retour</button>
                    <?php
                    // On vérifie que l'utilisateur a appuyé sur le bouton de modification des informations du compte
                } else if (isset($_POST["modification"])) {
                    // On rempli les champs du formulaire avec les informations contenues dans la base de données s'il y en a,
                    // sinon on met un placeholder afin d'indiquer quel champs correspond à quelle information à modifier
                    ?>
                    <input name="email" type="email" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+"
                           value=<?= $donnees['login'] ?>><br><br>
                    <?php if ($donnees['nom'] != "null") {
                        $nom = htmlspecialchars($donnees['nom'], ENT_QUOTES); ?>
                        <input name="nom" value='<?= $nom ?>'><br><br>
                    <?php } else { ?>
                        <input name="nom" placeholder="Nouveau nom"><br><br>
                    <?php }
                    if ($donnees['prenom'] != "null") {
                        $prenom = htmlspecialchars($donnees['prenom'], ENT_QUOTES); ?>
                        <input name="prenom" value='<?= $prenom ?>'><br><br>
                    <?php } else { ?>
                        <input name="prenom" placeholder="Nouveau prenom"><br><br>
                    <?php } ?>
                    <select name="sexe">
                        <option value="default" name="bdd"><?= $donnees['sexe'] ?></option>
                        <option value="N" name="aucun">Non renseigné</option>
                        <option value="F" name="homme">Femme</option>
                        <option value="H" name="femme">Homme</option>
                    </select><br><br>
                    <?php
                    if ($donnees['adresse'] != "null") {
                        $adresse = htmlspecialchars($donnees['adresse'], ENT_QUOTES); ?>
                        <input name="adresse" value='<?= $adresse ?>'><br><br>
                    <?php } else { ?>
                        <input name="adresse" placeholder="Nouvelle adresse"><br><br>
                    <?php }
                    if ($donnees['postal'] != 0) { ?>
                        <input name="postal" pattern="[0-9]{5}" value=<?= $donnees['postal'] ?>><br><br>
                    <?php } else { ?>
                        <input name="postal" placeholder="Nouveau code postal" pattern="[0-9]{5}"><br><br>
                    <?php }
                    if ($donnees['ville'] != "null") {
                        $ville = htmlspecialchars($donnees['ville'], ENT_QUOTES); ?>
                        <input name="ville" value='<?= $ville ?>'><br><br>
                    <?php } else { ?>
                        <input name="ville" placeholder="Nouvelle ville"><br><br>
                    <?php }
                    if ($donnees['noTelephone'] != 0) { ?>
                        <input name="telephone" type="tel" pattern="0[3, 6, 9, 7, 2, 1][0-9]{8}"
                               value=<?= $donnees['noTelephone'] ?>><br><br>
                    <?php } else { ?>
                        <input name="telephone" type="tel" placeholder="0xxxxxxxxx" pattern="0[3, 6, 9, 7, 2][0-9]{8}">
                        <br><br>
                    <?php } ?>
                    <br>
                    <input name="ancienMdp" type="password" placeholder="Ancien mot de passe"><br><br>
                    <input name="nouveauMdp" type="password" placeholder="Nouveau mot de passe"><br><br>
                    <input name="confirmationMdp" type="password" placeholder="Confirmation du nouveau mot de passe">
                    <br><br>
                    <br>
                    <p><input name="validation" type="submit" value="Enregistrer"></p>
                <?php } else {
                    // On affiche les informations du compte de l'utilisateur
                    ?>
                    <p>Email : <?php echo $donnees['login']; ?> </p>
                    <p>Nom : <?php if ($donnees['nom'] != "null") echo $donnees['nom']; ?> </p>
                    <p>Prenom : <?php if ($donnees['prenom'] != "null") echo $donnees['prenom']; ?> </p>
                    <p>Sexe : <?php echo $donnees['sexe']; ?> </p>
                    <p>Adresse : <br><?php if ($donnees['adresse'] != "null") echo $donnees['adresse'];
                        if ($donnees['postal'] != 0) echo ' ' . $donnees['postal'];
                        if ($donnees['ville'] != "null") echo ' ' . $donnees['ville']; ?></p>
                    <p>N° de téléphone : <?php if ($donnees['noTelephone'] != 0) echo $donnees['noTelephone']; ?> </p>
                    <p><input name="modification" type="submit" value="Modifier Informations"></p>
                    <?php
                }
                ?>
                <br>
            </form>
        </div>
        <div class="boxC">
            <form class="" action="#" method="post">
                <p>Email : <?php echo $_SESSION['login']; ?> </p>
                <?php if (isset($_POST["suppression"])) {
                    // On supprime l'utilisateur de la base de données si le bouton de suppression a été pressé
                    $requete = $bdd->prepare("DELETE FROM Utilisateur WHERE login = :login");
                    $login = $_SESSION['login'];
                    $requete->bindParam('login', $login);
                    $requete->execute();
                    $_SESSION = array();
                    session_destroy();
                    unset($_SESSION);
                    header("Location: ../");
                } ?>
                <br>
                <p><input name="suppression" type="submit" value="Supprimer le compte"></p>
            </form>

        </div>
    </div>
</div>

<?php
//On fait apparaître la structure du bas de la page
include_once("../StructurePage/piedDePage.php");
?>
