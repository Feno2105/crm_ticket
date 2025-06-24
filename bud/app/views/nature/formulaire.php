<?php
$actions = [];
$actions[0] = "/saveNature";
$actions[1] = "/updateNature";
$action = "";

if (isset($nature)) {
    $action = $actions[1];
} else {
    $action = $actions[0];
}

?>
<div class="div-form">
    <h2>
        <?php if (isset($nature)) {
            echo "Ajout d une nouvelle nature";
        } else {
            echo "Modification du nature";
        }
        ?>
    </h2>
    <form action="<?= $action ?>" method="post">
        <?php if (isset($nature)) { ?>
            <input type="hidden" name="id" value="<?= $nature['id'] ?>">
        <?php } ?>
        <div class="div-input">
            <label for="idC">Choix du categorie</label>
            <select name="idC" id="idC" required>
                <?php foreach ($categories as $categorie) { ?>
                    <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['libele']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="div-input">
            <label for="libele">Libele du nature</label>
            <input type="text" name="libele" id="libele" required <?php if (isset($nature)) { ?>
                value="<?= $nature['libele'] ?>" <?php } ?>>
        </div>
        <div class="div-submit-form">
            <button type="submit">Valider</button>
        </div>
    </form>
</div>