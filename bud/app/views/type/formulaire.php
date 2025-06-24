<?php
$actions = [];
$actions[0] = "/saveType";
$actions[1] = "/updateType";
$action = "";

if (isset($type)) {
    $action = $actions[1];
} else {
    $action = $actions[0];
}

?>
<div class="div-form">
    <h2>
        <?php if (isset($type)) {
            echo "Ajout d une nouvelle type";
        } else {
            echo "Modification du type";
        }
        ?>

    </h2>
    <form action="<?= $action ?>" method="post">
        <?php if (isset($type)) { ?>
        <input type="hidden" name="id" value="<?= $type['id'] ?>">
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
            <label for="libele">Libele du type</label>
            <input type="text" name="libele" id="libele" required <?php if (isset($type)) { ?>
                value="<?= $type['libele'] ?>" <?php } ?>>
        </div>
        <div class="div-submit-form">
            <button type="submit">Valider</button>
        </div>
    </form>
</div>