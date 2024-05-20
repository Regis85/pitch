<?php ob_start(); ?>
        <div class='entete'>
            <h1>
                Pitch & Putt
            </h1>
<?php if (isset($_SESSION['message']) && isset($_SESSION['message']['texte'])) { ?>
            <p class="<?= $_SESSION['message']['class']; ?>">
                <?= $_SESSION['message']['texte']; ?>
            </p>
<?php } ?>
        </div>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>

    <form method="POST">
        <div class='connexion' <?= $cacherConnect; ?> >
            <h2>Identifiants</h2>
            <p>
                <label for="identifiant">Identifiant :</label>
                <input type="text" id="identifiant" name="identifiant" size="12"
                       placeholder="<?= $_SESSION['id_pitch']; ?>" disabled/>
<?php if (!$_SESSION['connecte']) { ?>
                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" size="24" minlength="8"
                       pattern="[A-Za-z0-9]*[A-Za-z]+[A-Za-z0-9]*[0-9]+[A-Za-z0-9]*"/>
                <input type="hidden" id="id_soumit" name="id_soumit" value="connect" />
                <button>Se connecter</button>
<?php } else { ?>
                <input type="hidden" id="id_soumit" name="id_soumit" value="mdp" />
                <input type="hidden" name="connecte" value="<?= $_SESSION['connecte']; ?>" />
                <button>Changer le mot de passe</button>
<?php } ?>
            </p>
        </div>
    </form>

    <form enctype="multipart/form-data" method="POST">
        <div class='accueil' >
            <p>
                <input type="hidden" id="identifiant" name="identifiant"
                        value="<?= $_SESSION['id_pitch']; ?>" />
                <label for="nom">Nom du club : </label>
                <input type="text" id="nom" name="name" size="36"
                        value="<?= $_SESSION['club']['nom']; ?>" <?= $disabled; ?> />
                <input type="hidden" name="connecte" value="<?= $_SESSION['connecte']; ?>" />
            </p>
            <p>
                <label for="phone">Téléphone : </label>
                <input type="tel" id="phone" name="phone"
                        value="<?= $_SESSION['club']['telephone']; ?>" <?= $disabled; ?> />
                <label for="courriel">Courriel : </label>
                <input type="text" id="courriel" name="courriel" size="36"
                        value="<?= $_SESSION['club']['courriel']; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <a href="photos/<?= $_SESSION['club']['image'] ?>" target="_blank" >
                <img class="photoClub" src="photos/<?= $_SESSION['club']['image']; ?>"
                        alt="<?php echo $_SESSION['club']['nom'] ?>" title="Afficher l'image" />
<?php if ($disabled !=="disabled") { ?>
                </a>
            </p>
            <p>
                <input type="hidden" name="MAX_FILE_SIZE" value="31457280" />
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" accept=".png, .jpg, .jpeg, .jpeg," />
<?php } ?>
            </p>
            <p>
                <label for="actualites">Actualités</label>
                <br>
                <textarea id="actualites"
                        class="tab4"
                        name="actualites"
                        rows="10"
                        cols="80"
                        <?= $disabled; ?> ><?= $_SESSION['club']['actualites']; ?></textarea>
            </p>
            <p>
                <label for="gps">Coordonnées GPS (Lat/Lon):</label>
                <input type="text" id="gps" name="gps" size="36"
                        value="<?= $_SESSION['club']['gps']; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="pitch">Pitch & Putt :</label>
                <input type="radio" id="pitch" name="pitchCompact"
                        <?php if ($_SESSION['club']['pitch']){ echo " checked ";}; ?>
                        <?= $disabled; ?> />
                <label for="compact">Compact :</label>
                <input type="radio" id="compact" name="pitchCompact"
                        <?php if (!$_SESSION['club']['pitch']){ echo " checked ";}; ?>
                        <?= $disabled; ?> />
            </p>
            <p>
                <label for="trous">Nombre de greens :</label>
                <input type="text" id="trous" name="green" size="5"
                        value="<?= $_SESSION['club']['nbGreen']; ?>" <?= $disabled; ?> />
                <label for="departs">Nombre de départs différents :</label>
                <input type="text" id="departs" name="tee" size="5"
                        value="<?= $_SESSION['club']['nbDepart']; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="greenSyn">Greens synthétiques :</label>
                <input type="radio" id="greenSyn" name="greens"
                        <?php if ($_SESSION['club']['greenSynthe']){ echo " checked ";} ?>
                        value=1
                         <?= $disabled; ?> />
                <label for="greenHerbe">en herbe :</label>
                <input type="radio" id="greenHerbe" name="greens"
                        <?php if (!$_SESSION['club']['greenSynthe']){ echo " checked ";} ?>
                        value=0
                        <?= $disabled; ?> />
            </p>
            <p>
                <label for="departSyn">Départs synthétiques :</label>
                <input type="radio" id="departSyn" name="tees"
                        <?php if ($_SESSION['club']['departSynthe']){ echo " checked ";} ?>
                        value=1
                        <?= $disabled; ?> />
                <label for="departHerbe">en herbe :</label>
                <input type="radio" id="departHerbe" name="tees"
                        <?php if (!$_SESSION['club']['departSynthe']){ echo " checked ";} ?>
                        value=0
                        <?= $disabled; ?> />
            </p>
            <p>
                <label for="compet">Parcours de compétition :</label>
                <input type="checkbox" id="compet" name="competition"
                        <?php if ($_SESSION['club']['competition']){ echo " checked ";} ?>
                        <?= $disabled; ?> />
                <label for="entrainement">d'entrainement :</label>
                <input type="checkbox" id="entrainement" name="training"
                        <?php if ($_SESSION['club']['entrainement']){ echo " checked ";} ?>
                        <?= $disabled; ?> />
            </p>
            <p>
                <label for="longueur">Longueur totale :</label>
                <input type="text" id="longueur" name="long" size="6"
                        value="<?= $_SESSION['club']['longTotale']; ?>" <?= $disabled; ?> />
                mètres
            </p>

            <p>
                <label for="trous01">Longueur du trou 1 :</label>
                <input type="text" id="trous01" name="trous[0]" size="4"
                        value="<?=$_SESSION['club']['trou'][0]; ?>"  <?= $disabled; ?> />
                <label for="trous02">trous 2 :</label>
                <input type="text" id="trous02" name="trous[1]" size="4"
                        value="<?=$_SESSION['club']['trou'][1]; ?>" <?= $disabled; ?> />
                <label for="trous03">trous 3 :</label>
                <input type="text" id="trous03" name="trous[2]" size="4"
                        value="<?=$_SESSION['club']['trou'][2]; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="trous04">trous 4 :</label>
                <input type="text" id="trous04" name="trous[3]" size="4"
                        value="<?=$_SESSION['club']['trou'][3]; ?>" <?= $disabled; ?> />
                <label for="trous05">trous 5 :</label>
                <input type="text" id="trous05" name="trous[4]" size="4"
                        value="<?=$_SESSION['club']['trou'][4]; ?>" <?= $disabled; ?> />
                <label for="trous06">trous 6 :</label>
                <input type="text" id="trous06" name="trous[5]" size="4"
                        value="<?=$_SESSION['club']['trou'][5]; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="trous07">trous 7 :</label>
                <input type="text" id="trous07" name="trous[6]" size="4"
                        value="<?=$_SESSION['club']['trou'][6]; ?>" <?= $disabled; ?> />
                <label for="trous08">trous 8 :</label>
                <input type="text" id="trous08" name="trous[7]" size="4"
                        value="<?=$_SESSION['club']['trou'][7]; ?>" <?= $disabled; ?> />
                <label for="trous09">trous 9 :</label>
                <input type="text" id="trous09" name="trous[8]" size="4"
                        value="<?=$_SESSION['club']['trou'][8]; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="trous10">trous 10 :</label>
                <input type="text" id="trous10" name="trous[9]" size="4"
                        value="<?=$_SESSION['club']['trou'][9]; ?>" <?= $disabled; ?> />
                <label for="trous11">trous 11 :</label>
                <input type="text" id="trous11" name="trous[10]" size="4"
                        value="<?=$_SESSION['club']['trou'][10]; ?>" <?= $disabled; ?> />
                <label for="trous12">trous 12 :</label>
                <input type="text" id="trous12" name="trous[11]" size="4"
                        value="<?=$_SESSION['club']['trou'][11]; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="trous13">trous 13 :</label>
                <input type="text" id="trous13" name="trous[12]" size="4"
                        value="<?=$_SESSION['club']['trou'][12]; ?>" <?= $disabled; ?> />
                <label for="trous14">trous 14 :</label>
                <input type="text" id="trous14" name="trous[13]" size="4"
                        value="<?=$_SESSION['club']['trou'][13]; ?>" <?= $disabled; ?> />
                <label for="trous15">trous 15 :</label>
                <input type="text" id="trous15" name="trous[14]" size="4"
                        value="<?=$_SESSION['club']['trou'][14]; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="trous16">trous 16 :</label>
                <input type="text" id="trous16" name="trous[15]" size="4"
                        value="<?= isset ($_SESSION['club']['trou'][15]) ? $_SESSION['club']['trou'][15] : ""; ?>" <?= $disabled; ?> />
                <label for="trous17">trous 17 :</label>
                <input type="text" id="trous17" name="trous[16]" size="4"
                        value="<?=$_SESSION['club']['trou'][16]; ?>" <?= $disabled; ?> />
                <label for="trous18">trous 18 :</label>
                <input type="text" id="trous18" name="trous[17]" size="4"
                        value="<?=$_SESSION['club']['trou'][17]; ?>" <?= $disabled; ?> />
            </p>
            <p>
                <label for="acces">
                    Conditions d’accès : baptême, licence, carte verte, âges, étiquette …
                </label>
                <br>
                <textarea id="acces"
                        class="tab4"
                        name="acces"
                        rows="10"
                        cols="80"
                        <?= $disabled; ?>><?= $_SESSION['club']['acces']; ?></textarea>
            </p>
            <p>
                <label for="entraineOui">Zone d'entrainement : Oui</label>
                <input type="radio" id="entraineOui" name="entraine"
                        <?php if ($_SESSION['club']['zoneEntrainement']){ echo " checked ";} ?>
                         <?= $disabled; ?> />
                <label for="entraineNon">Non</label>
                <input type="radio" id="entraineNon" name="entraine"
                        <?php if (!$_SESSION['club']['zoneEntrainement']){ echo " checked ";} ?>
                          <?= $disabled; ?> />
            </p>
            <p>
                <label for="clubLoc">Clubs : En location</label>
                <input type="radio" id="clubLoc" name="club"
                        <?php if ($_SESSION['club']['locationClubs'] === 2){ echo " checked ";} ?>
                        value=2 <?= $disabled; ?> />
                -
                <label for="clubPret">Prêt :</label>
                <input type="radio" id="clubPret" name="club"
                        <?php if ($_SESSION['club']['locationClubs'] === 1){ echo " checked ";} ?>
                        value=1 <?= $disabled; ?> />
                -
                <label for="clubNon">Non :</label>
                <input type="radio" id="clubNon" name="club"
                        <?php if ($_SESSION['club']['locationClubs'] === 0){ echo " checked ";} ?>
                        value=0 <?= $disabled; ?> />
            </p>
            <p>
                <label for="sacLoc">Sacs : En location</label>
                <input type="radio" id="sacLoc" name="sac"
                        <?php if ($_SESSION['club']['locationSac'] === 2){ echo " checked ";} ?>
                        value=2 <?= $disabled; ?> />
                -
                <label for="sacPret">Prêt :</label>
                <input type="radio" id="sacPret" name="sac"
                        <?php if ($_SESSION['club']['locationSac'] === 1){ echo " checked ";} ?>
                        value=1 <?= $disabled; ?> />
                -
                <label for="sacNon">Non :</label>
                <input type="radio" id="sacNon" name="sac"
                        <?php if ($_SESSION['club']['locationSac'] === 0){ echo " checked ";} ?>
                        value=0  <?= $disabled; ?> />
            </p>
            <p>
                <label for="tarifs">
                    Tarifs des droits de jeu : formules d’abonnement, green-fees
                    (en fonction des âges) :
                </label>
                <br>
                <textarea id="tarifs"
                    name="tarifs"
                    rows="10"
                    cols="80"
                    <?= $disabled; ?>><?= $_SESSION['club']['tarifs']; ?></textarea>
            </p>
            <p>
                <label for="heures">Horaires (saisons, jours, heures) :</label>
                <br>
                <textarea id="heures"
                    name="heures"
                    rows="10"
                    cols="80"
                    <?= $disabled; ?>><?= $_SESSION['club']['horaires']; ?></textarea>
            </p>
            <p>
                <label for="resto">Restaurant :</label>
                <input type="checkbox" id="resto" name="resto"
                        <?php if ($_SESSION['club']['restaurant']){ echo " checked ";} ?>
                        <?= $disabled; ?> />
                <label for="restoRapide">Restauration rapide :</label>
                <input type="checkbox" id="restoRapide" name="restoRapide"
                        <?php if ($_SESSION['club']['restauRapide']){ echo " checked ";} ?>
                        <?= $disabled; ?> />
            </p>
            <p>
                <label for="menuRapide">Horaires restauration (jours, heures) :</label>
                <br>
                <textarea id="menuRapide"
                        name="menuRapide"
                        rows="10"
                        cols="80"
                        <?= $disabled; ?>><?= $_SESSION['club']['horaireRestau']; ?></textarea>
            </p>
            <p>
                <label for="web">Site Web :</label>
                <input type="text" id="web" name="web" size=40
                        value="<?= $_SESSION['club']['siteWeb'] ?>"
                        <?= $disabled; ?> />
            </p>
<?php if ($cacherEnregistre !== "hidden") { ?>
            <p>
                <input type="hidden" id="id_soumit" name="id_soumit" value="donnees" />
                <input type="submit" value="Enregistrer" <?= $cacherEnregistre; ?> />
            </p>
<?php } ?>
        </div>
<?php if ($_SESSION['connecte']) { ?>
        <div class="dirigeants center">
            <p>
                <input type="hidden" id="id_Gerant" name="id_Gerant"
                        value = <?= $_SESSION['club']['dirigeants'][0][0] ?> />
                <label for="gerant">Directeur/gérant</label>
                <input type="text" id="gerant" name="gerant" size=50
                        value="<?= $_SESSION['club']['dirigeants'][0][1] ?>" />
                <label for="gerantTel">téléphone : </label>
                <input type="text" id="gerantTel" name="gerantTel" size=20
                        value="<?= $_SESSION['club']['dirigeants'][0][2] ?>" />
                <label for="gerantCourriel">Courriel :</label>
                <input type="text" id="gerantCourriel" name="gerantCourriel" size=40
                    value="<?= $_SESSION['club']['dirigeants'][0][3] ?>" />
            </p>
            <p>
                <input type="hidden" id="id_AS" name="id_AS"
                        value = <?= $_SESSION['club']['dirigeants'][1][0] ?> />
                <label for="presidentAS">Pésident de l'AS</label>
                <input type="text" id="presidentAS" name="presidentAS" size=50
                        value="<?= $_SESSION['club']['dirigeants'][1][1] ?>" />
                <label for="asTel">téléphone : </label>
                <input type="text" id="asTel" name="asTel" size=20
                        value="<?= $_SESSION['club']['dirigeants'][1][2] ?>" />
                <label for="asCourriel">Courriel :</label>
                <input type="text" id="asCourriel" name="asCourriel" size=40
                        value="<?= $_SESSION['club']['dirigeants'][1][3] ?>" />
            </p>
            <p>
                <input type="hidden" id="id_CPPF" name="id_CPPF"
                        value = <?= $_SESSION['club']['dirigeants'][2][0] ?> />
                <label for="cppf">Référent CPPF</label>
                <input type="text" id="cppf" name="cppf" size=50
                        value="<?= $_SESSION['club']['dirigeants'][2][1] ?>" />
                <label for="cppfTel">téléphone : </label>
                <input type="text" id="cppfTel" name="cppfTel" size=20
                        value="<?= $_SESSION['club']['dirigeants'][2][2] ?>" />
                <label for="cppfCourriel">Courriel :</label>
                <input type="text" id="cppfCourriel" name="cppfCourriel" size=40
                        value="<?= $_SESSION['club']['dirigeants'][2][3] ?>" />
            </p>
            <!-- Affichage des pros déjà inscrits
            <p>
                <label for="pro1">Enseignant du golf</label>
                <input type="text" id="pro1" name="pro" size=50 value="" />
                <label for="">téléphone : </label>
                <input type="text" id="nouveauPro1Tel" name="nouveauPro1Tel" size=20 value="" />
                <label for="">Courriel :</label>
                <input type="text" id="nouveauPro1Courriel" name="nouveauPro1Courriel" size=40 value="" />
            </p>

            <p>
                <input type="hidden" id="id_nouveauPro" name="id_nouveauPro"
                        value= 0 />
                <label for="nouveauPro">Enseignant du golf</label>
                <input type="text" id="nouveauPro" name="nouveauPro" size=50 value="" />
                <label for="nouveauProTel">téléphone : </label>
                <input type="text" id="nouveauProTel" name="nouveauProTel" size=20 value="" />
                <label for="nouveauProCourriel">Courriel :</label>
                <input type="text" id="nouveauProCourriel"
                        name="nouveauProCourriel" size=40 value="" />
            </p>
            -->
            <p>
                <input type="submit" value="Enregistrer" />
            </p>
        </div>
<?php } ?>
    </form>

    <form method="POST">
        <div class='connexion' <?= $cacherConnect; ?> >
            <p class='center' >
                <input type="hidden" id="id_soumit" name="id_soumit" value="Quitter" />
                <button>Quitter</button>
            </p>
        </div>
    </form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
