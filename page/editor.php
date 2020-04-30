<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();
$pack = getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId[0] == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || !userOwnPack($_SESSION["accountId"], $_GET["id"]) || $pack["published"] == 1) {
    redirectTo404();
}

// TODO: Persistance

$error = "";
$errorOnCards = [];

if (!empty($_POST)) {
    if (isset($_POST["addCard"])) {
        createCard($_GET["id"]);
    } else if (isset($_POST["validateCard"])) {
        if ($_POST["qcard-".$_POST["id"]] === "") {
            $error .= "<br>- Veuillez entrer une question.";
        }

        if ($_POST["acard-".$_POST["id"]] === "") {
            $error .= "<br>- Veuillez entrer une réponse.";
        }

        if ($error === "") {
            validateCard($_POST["id"], $_POST["qcard-".$_POST["id"]], $_POST["acard-".$_POST["id"]]);
        } else {
            redirect("editor?id=".$_GET["id"]."&errorType=0&cardId=".$_POST["id"]."&error=".urlencode($error));
        }
    } else if (isset($_POST["suppressCard"])) {
        removeCard($_POST["id"]);
    } else if (isset($_POST["modifyCard"])) {
        modifyCard($_POST["id"]);
    } else if (isset($_POST["publishPack"])) {
        $cards = getAllCardsOfPack($_GET["id"]);

        foreach ($cards as $card) {
            if ($card["confirmed"] == 0) {
                array_push($errorOnCards, $card["id"]);
            }
        }

        if (count($errorOnCards) > 0) {
            redirect("editor?id=".$_GET["id"]."&errorType=1");
        } else {
            validatePack($_GET["id"]);

            redirectToHome();
        }
    } else if (isset($_POST["suppressPack"])) {
        removePack($_GET["id"]);

        redirectToHome();
    } else if (isset($_POST["editPack"])) {
        redirect("editor/modify?id=".$_GET["id"]);
    }

    redirect("editor?id=".$_GET["id"]);
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle("Éditeur de paquet");

$cards = getAllCardsOfPack($_GET["id"]);
?>

<main>
    <?php
    echo makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <h2>Créateur de paquet</h2>
        </div>

        <?php
        echo makeToolbarNew(1, FALSE);
        ?>

        <article id="content-main">
            <section>
                <div class="grid-container">
                    <div>
                        <h1 style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                        <h4 style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center; margin-left: 100px; cursor: pointer;">
                        <form method="post" id="edit-pack-form">
                            <input type="hidden" name="editPack" value="Éditer" />
                            <div style="display: flex; align-items: center; justify-content: center;" onclick="document.forms['edit-pack-form'].submit();">
                                <div style="font-size: 30px; color: black; position: absolute;">􀛷</div>
                                <div style="font-size: 34px; color: #1FCAAC; position: absolute;">􀈌</div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <br>

            <?php
            if ($pack["description"] != "") {
            ?>
                <section>
                    <h3>Description</h3>
                    <h4 style="font-weight: 500;"><?php echo $pack["description"] ?></h4>
                </section>
                <br>
            <?php
            }
            ?>

            <section class="section-cards">
                <h4>Cartes</h4>
                <?php
                foreach ($cards as $value) {
                    ?>
                    <form method="post" id="card-<?php echo $value["id"] ?>-form">
                        <input type="hidden" name="id" value="<?php echo $value["id"] ?>" />
                        <div class="cards-container">
                            <?php
                            echo makeCardEditable("qcard-".$value["id"], "Écrivez votre question...", $value["question"], $value["confirmed"]);
                            echo makeCardEditable("acard-".$value["id"], "Écrivez votre réponse...", $value["answer"], $value["confirmed"]);
                            ?>

                            <?php
                            if ($value["confirmed"] == 1) {
                                ?>
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <h4>Question validé!</h4>
                                </div>
                                <?php
                            }
                            ?>
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <input id="suppress-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="suppressCard" value="Supprimer" style="width: 150px; height: 32px;  background-color: #FF3B30;" />

                                <?php
                                if ($value["confirmed"] == 0) {
                                    ?>
                                    <input id="validate-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="validateCard" value="Valider" style="width: 150px; height: 32px; "/>
                                    <?php
                                } else {
                                    ?>
                                    <input id="modify-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="modifyCard" value="Modifier" style="width: 150px; height: 32px; "/>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (isset($_GET["error"]) && $_GET["errorType"] == 0 && $value["id"] == $_GET["cardId"]) {
                        ?>
                            <div style="width: 100%; margin: 20px 10px;">
                                <p class="form-label-error" style="text-align: left;">􀁡 Validation impossible!<?php echo $_GET["error"] ?></p>
                            </div>
                        <?php
                        } else if (isset($_GET["errorType"]) && $_GET["errorType"] == 1 && $value["confirmed"] == 0) {
                        ?>
                            <div style="width: 100%; margin: 20px 10px;">
                                <p class="form-label-error" style="text-align: left;">􀁡 Publication impossible!<br>- Veuillez valider ou supprimer cette carte!</p>
                            </div>
                        <?php
                        }
                        ?>
                    </form>
                <?php
                }
                ?>

                <div class="cards-container">
                    <form method="post" id="add-card-form">
                        <input type="hidden" name="addCard" value="Ajouter" />
                        <?php
                        echo makeCardPlus();
                        ?>
                    </form>
                </div>
            </section>
            <br>

            <section>
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Pensez à valider vos cartes avant de quitter!<br>Ou leur contenu ne sera pas enregistrer.</h6>
            </section>
        </article>
    </div>
</main>
