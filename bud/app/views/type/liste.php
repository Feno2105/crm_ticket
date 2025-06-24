<?php

?>
<table border="1">
    <tr>
        <th>Categorie</th>
        <th>Libele</th>
    </tr>
    <?php for ($i = 0; $i < count($types); $i++) { ?>
        <tr>
            <td><?= $types[$i]['idC'] ?></td>
            <td><?= $types[$i]['libele'] ?></td>
            <td><a href="/deleteType?id=<?= $types[$i]['id'] ?>">Delete</a></td>
            <td><a href="/typeForm?id=<?= $types[$i]['id'] ?>">Update</a></td>
        </tr>
    <?php } ?>
</table>