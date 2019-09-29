<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE
try{
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=renduphp', "root", "");
} catch (Exception $e){
    echo "erreur de connection à la base de donnée";
}


## ETAPE 1

## RECUPERER TOUT LES PERSONNAGES CONTENU DANS LA TABLE personnages
$showperso=$pdo->prepare('SELECT * FROM personnages');
$showperso->execute();
$show = $showperso->fetchAll(PDO::FETCH_ASSOC);


## ETAPE 2

## LES AFFICHERS DANS LE HTML
## AFFICHER SON NOM, SON ATK, SES PV, SES STARS

## ETAPE 3

## DANS CHAQUE PERSONNAGE JE VEUX POUVOIR APPUYER SUR UN BUTTON OU IL EST ECRIT "STARS"

## LORSQUE L'ON APPUIE SUR LE BOUTTON "STARS"

## ON SOUMET UN FORMULAIRE QUI METS A JOURS LE PERSONNAGE CORRESPONDANT (CELUI SUR LEQUEL ON A CLIQUER) EN INCREMENTANT LA COLUMN STARS DU PERSONNAGE DANS LA BASE DE DONNEE




#######################
## ETAPE 4
# AFFICHER LE MSG "PERSONNAGE ($name) A GAGNER UNE ETOILES"

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Acceuil</a>
    <a href="./personnage.php" class="nav-link">Mes Personnages</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>
<h1>Mes personnages</h1>
<div class="w-100 mt-5">

</div>
<?php if (!empty($show)){
    foreach ($show as $perso){
        if(isset($_POST["stars". $perso["id"]])){
            $perso["stars"]++;
            $addStars= $pdo->prepare('UPDATE personnages SET stars=:stars WHERE name=:name');
            $jeveuxdesstars = $addStars->execute([":stars"=>$perso["stars"], ":name"=>$perso["name"]]);
            echo $perso["name"]." a gagné 1 étoile <br>";

        }
        ?>

        <tr>
            <td>Nom : <?php echo $perso["name"]; ?></td><br>
            <td>ATK : <?php echo $perso["atk"]; ?></td><br>
            <td>PV : <?php echo $perso["pv"]; ?></td><br>
            <td>Stars : <?php if($perso["stars"]==0){
                        echo "il n'y a pas d'etoiles pour le moment";
                }
                else{
                    echo $perso["stars"];
                }?></td><br>
            <form method="POST">
                <button name="stars<?php echo $perso["id"] ?>">Stars</button>
            </form>




        </tr>
        <br><br><br><?php
    }


} ?>

</body>
</html>
