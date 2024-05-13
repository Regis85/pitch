<?php ob_start(); ?>
        <!-- <?= print_r($_SESSION); ?> <!-- -->
        <div class='entete'>
            <h1>
                Pitch & Putt
            </h1>
        </div>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>

        <div class='accueil' >
            <p>
                <span id="nom" class="donnee"><?= $pitch["nom"] ?></span>
            </p>
            <p>
                <a href="photos/<?= $pitch['image']; ?>" target="_blank" >
                    <img src="photos/<?= $pitch['image']; ?>" title="Afficher l'image" />
                </a>
            </p>
            <p>
<?php if ($pitch["telephone"] !="") { ?>
                Téléphone : <?= $pitch["telephone"] ?>
                -
<?php } ?>
<?php if ($pitch["siteWeb"] != Null) { ?>
                <a href=<?= $pitch["siteWeb"]; ?> target="_blank"> Site Web</a>
                -
<?php } ?>
<?php if ($pitch["courriel"] !="") { ?>
                <a href=mailto:<?= $pitch["courriel"] ?> >Envoyer un courriel</a>
<?php } ?>
            </p>
<?php if ($pitch["actualites"] != "") { ?>
            <p>
                Actualités
                <br>
                <textarea class="affiche" readonly="yes">
                    <?php echo $pitch["actualites"] ?>
                </textarea>
            </p>
<?php } ?>
            <p class="zoneText" >
                    Coordonnées GPS (Lat/long):
                    <?php echo $pitch["gps"] ?>
            </p>
            <p>
                <span class="zoneText" >
                    <?php if ($pitch["pitch"] === 1) { ?>
                        Pitch & Putt
                    <?php } else if ($pitch["pitch"] === 0) { ?>
                        Sur Compact/Grand parcours
                    <?php } ?>
                    -
                    <?php echo $pitch["nbGreen"] ?> trous
                    -
                    <?php echo $pitch["nbDepart"] ?> départ par trou
                </span>
            </p>
            <p>
                <span class="zoneText" >
                    <?php if ($pitch["departSynthe"] === 1) { ?>
                        Départs synthétiques
                    <?php } else if ($pitch["departSynthe"] === 0) { ?>
                        Départs sur herbe
                    <?php } ?>
                    -
                    <?php if ($pitch["greenSynthe"] === 1) { ?>
                        Greens synthétiques
                    <?php } else if ($pitch["greenSynthe"] === 0) { ?>
                        Greens en herbe
                    <?php } ?>
                </span>
            </p>
<?php if ($pitch["competition"] === 1 or $pitch["entrainement"] === 1) { ?>
            <p>
                <span class="zoneText" >
    <?php if ($pitch["competition"] === 1) { ?>
                        Parcours de compétition
    <?php } ?>
    <?php if ($pitch["entrainement"] === 1) { ?>
                        - Espace d'entraînement
    <?php } ?>
                </span>
            </p>
<?php } ?>
            <p>
                <span class="zoneText" >
                    Longueur totale :
                    <span id="longueur"><?php echo ( $pitch["longTotale"]) ?></span> mètres
                </span>
            </p>
            <p>
                <span class="zoneText" >
                    <?php
                    $i = 0;
                    foreach ($trous as $cle => $valeur) {
                        if ($i == 3) {
                            echo "<br>";
                            $i = 0;
                        }
                        $i +=1;
                        echo "trou " . $cle + 1 . " : " . $valeur[0] . "m &nbsp";
                    }
                    ?>
                </span>
            </p>
            <p>
                Conditions d’accès : baptême, licence, carte verte, âges, étiquette …
                <br>
                <textarea class="affiche" readonly="yes">
<?php echo $pitch["acces"] ?>
                </textarea>
            </p>
<?php if ($pitch["zoneEntrainement"] === 1) { ?>
            <p>
                <span class="zoneText" >
                    Zône d'entraînement disponible
                </span>
            </p>
<?php } ?>
            <p>
                <span class="zoneText" >
<?php if ($pitch["locationClubs"] === 2) { ?>
                    Location de clubs
<?php } else if ($pitch["locationClubs"] === 1) { ?>
                    Prêt de clubs
<?php } ?>
                -
<?php if ($pitch["locationClubs"] === 2) { ?>
                    Location de sacs
<?php } else if ($pitch["locationClubs"] === 1) { ?>
                    Prêt de sacs
<?php } ?>
                </span>
            </p>
            <p>
                Tarifs
                <br>
                <textarea class="affiche" readonly="yes">
<?= $pitch["tarifs"] ?>
                </textarea>
            </p>
            <p>
                Horaires (saisons, jours, heures) :
                <br>
                <textarea class="affiche" readonly="yes">
<?php echo $pitch["horaires"] ?>
                </textarea>
<?php if ($pitch["restaurant"] == 10 or $pitch["restauRapide"] == 1) { ?>
            <p>
                <span class="zoneText" >
    <?php if ($pitch["restaurant"]) { ?>Restaurant<?php } ?>

    <?php if ($pitch["restauRapide"]) { ?> - Restauration rapide<?php } ?>
                </span>
             </p>
<?php } ?>
            <p>
                Horaires Restauration :
                <br>
                <textarea class="affiche" readonly="yes">
<?php echo $pitch["horaireRestau"] ?>
                </textarea>
            </p>
<?php if ($pitch["siteWeb"] != Null) {?>
            <p>
                <a href=<?php echo $pitch["siteWeb"]; ?> target="_blank"> Site Web</a>
            </p>
<?php } ?>
            <p>
                Les données de ce site sont peut-être obsolètes,
                n'hésitez pas à contacter l'accueil du golf.
            </p>
        </div>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
