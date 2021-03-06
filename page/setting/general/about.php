<?php

use function cardback\system\checkAccountConnection;
use function cardback\utility\changeTitle;

checkAccountConnection(TRUE);
changeTitle("À propos de");
?>

<main>
    <?php
    $getSidebar(3);
    ?>

    <div id="page-main">
        <?php
        $getToolbar();
        ?>

        <article id="content-settings-main">
            <?php
            $getSettings(1);
            ?>

            <section
                    style="width: 540px; position: fixed; top: 0;">
                <div
                        class="settings-top-category-container">
                    <h3
                            class="settings-title theme-default-text">
                        À propos de <span style="font-weight: 900;">cardback</span></h3>
                </div>

                <div
                        class="settings-category-container">
                    <h3
                            class="settings-title theme-default-text">
                        Pages d'informations</h3>
                </div>
                <div
                        class="settings-option-container">
                    <a
                            href="<?php echo $serverUrl; ?>faq">
                        <h3 class="settings-title settings-title-button theme-default-text">
                            Foire aux questions</h3></a>
                </div>
            </section>
        </article>
    </div>
</main>
