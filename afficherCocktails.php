<?php
//Fonction permettant de réduire la duplication de code
function afficherCocktails(bool|array $cocktails, int $i, string $cheminImage): array
{
    //On ne parcourt pas les élements vides de l'Array
    if (!empty($cocktails[$i])) {
        $nomImage = formatageString($cocktails[$i]['nom']);
        $nomFinal = $cheminImage . $nomImage . ".jpg";
        ?>
        <div class="w3-quarter">
            <div class="img">
                <img src="<?= $nomFinal ?>" alt="<?= $cocktails[$i]['nom'] ?>" class="images">
            </div>
            <a href='VisualisationRecette/index.php?cocktail=<?= $cocktails[$i]['nom'] ?>'><h3> <?= $cocktails[$i]['nom'] ?></h3></a>
        </div>
    <?php }
    return array($cocktails, $nomImage, $nomFinal);
}