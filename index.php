<?php
require_once "core/config.php";
require_once "core/utility.php";
require_once "core/account.php";
require_once "core/pack.php";
require_once "core/feedback.php";

// Définis la timezone et langue par défaut
date_default_timezone_set("Europe/Paris");
setlocale(LC_TIME, 'fr_FR.UTF-8');

// On démarre la session
session_start();

// Charge la base de donnée
$db = mysqli_connect("35.205.34.35", "root", "@!hk-fpv-io2-2019!@", "cardback");

if (!$db) {
    echo mysqli_connect_error();
}

// Défini la page à charger
$link = isset($_GET["link"]) ? "page/".$_GET['link'] : "page/welcome";

if (!file_exists($link.".php")) {
    $link = "page/404";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Titre de la page -->
    <title>cardback</title>

    <!-- Informations générales -->
    <meta charset="utf-8">

    <!-- Favicon -->
    <meta name="theme-color" content="#FFFFFF">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $baseUrl ?>/res/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $baseUrl ?>/res/favicon/favicon-16x16.png">

    <!-- Feuille de style -->
    <link rel="stylesheet" href="<?php echo $baseUrl ?>/res/style/utility/normalize.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>/res/style/base.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>/res/style/component.css">
    <?php
    // Indique le lien vers le CSS de la page voulu
    if (file_exists("res/style/".$link.".css")) {
        echo '<link rel="stylesheet" href="'.$baseUrl.'/res/style/'.$link.'.css">';
    }
    ?>
</head>
<body>
    <style>
        <?php
        require "core/font/sf-pro-rounded.css.php";
         ?>
    </style>

    <?php
    // Charge la page voulu
    require $link.".php";
    ?>

    <script src="<?php echo $baseUrl ?>/res/script/component.js"></script>

</body>
</html>
<?php
// Ferme la connexion à la base de donnée
mysqli_close($db);
?>