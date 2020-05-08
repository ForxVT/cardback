<?php namespace cardback\component;

function makeCard($textOnFront, $textOnBack, $rotate = TRUE, $style = "", $link = "") {
    global $serverUrl;

    return '
    <a class="card" style="'.$style.'" '.($link != "" ? 'href="'.$link.'"' : '').'>
        <div class="card-container card-container-rotate" style="transform: rotate('.($rotate ? rand(-5, 5) : 0). 'deg)">
            <div class="card-main">
                <div class="card-front">
                    <img class="card-image" src="'.$serverUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                    <div class="card-text-middle">'.$textOnFront.'</div>
                </div>
                <div class="card-back">
                    <img class="card-image" src="'.$serverUrl.'/res/image/card-background.svg" alt="Carte fond arrière"/>
                    <div class="card-text-middle">'.$textOnBack.'</div>
                </div>
             </div>
         </div>
     </a>';
}

function makeCardDetailed($title, $creatorName, $creationDate, $link = "", $message = "Serez-vous capable de trouver toutes les réponses?", $rotate = TRUE) {
    global $serverUrl;

    return '
    <a class="card" href="'.$link.'" style="outline: none; color: black;">
        <div class="card-container card-container-rotate" style="transform: rotate('.($rotate ? rand(-5, 5) : 0). 'deg); cursor: pointer;">
            <div class="card-main">
                <div class="card-front">
                    <img class="card-image" src="'.$serverUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                    <div class="card-text-top">'.$title.'</div>
                    <div class="card-text-bottom">Créé par '.$creatorName.'<br>'.$creationDate.'</div>
                </div>
                <div class="card-back">
                    <img class="card-image" src="'.$serverUrl.'/res/image/card-background.svg" alt="Carte fond arrière"/>
                    <div class="card-text-middle">'.$message.'</div>
                </div>
             </div>
         </div>
     </a>';
}

function makeCardPlus() {
    global $serverUrl;

    return '
        <label class="card" style="position: relative; display: block;">
            <input type="submit" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; visibility: hidden;" name="add-card">
                    <div class="card-container" style="cursor: pointer;">
                        <div class="card-main">
                            <div class="card-front">
                                <img class="card-image" src="'.$serverUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                                <div class="card-text-middle theme-default-text" style="font-size: 28px; color: black;">􀛷</div>
                                <div class="card-text-middle color-text" style="font-size: 34px;">􀁍</div>
                            </div>
                         </div>
                     </div>
            </input>
        </label>';
}

function makeCardEditable($name, $placeholder, $value = "", $readonly = FALSE, $autocomplete = TRUE, $showStamp = 0) {
    global $serverUrl;

    return '
    <div class="card">
        <div class="card-container">
            <div class="card-main">
                <div class="card-front">
                    <img class="card-image" src="'.$serverUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                    <label for="'.$name.'"></label>
                    <textarea style="text-align: center; resize: none; font-size: 17px; font-weight: bold;" autocomplete="'.($autocomplete ? "on" : "off").'" id="'.$name.'-textbox" class="textbox-main textbox-card" type="textarea" name="'.$name.'" placeholder="'.$placeholder.'" maxlength="159"'.($readonly ? ' readonly' : '').'>'.$value.'</textarea>
                </div>
                '.($showStamp != 0 ? '
                <div style="display: flex; align-items: center; justify-content: center; margin-left: 240px; margin-top: 10px;">
                    <div style="font-size: 30px; color: black; position: absolute;">􀛷</div>
                    <div class="'.($showStamp == 1 ? 'color-text' : '').'" style="font-size: 34px;'.($showStamp == 0 ? ' color: #FF3B30;' : '').'; font-weight: bold; position: absolute;">'.($showStamp == 1 ? '􀁣' : '􀁡').'</div>
                </div>' : '').'
             </div>
         </div>
     </div>';
}