<?php

?>
<table class="data-table">
    <thead>
        <tr>
            <th>Categorie</th>
            <th>Libele</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < count($natures); $i++) { ?>
            <tr>
                <td><?= $natures[$i]['idC'] ?></td>
                <td><?= $natures[$i]['libele'] ?></td>
                <td>
                    <a href="/natureForm?id=<?= $natures[$i]['id'] ?>" class="action-link update-link">Update</a>
                    <a href="/deleteNature?id=<?= $natures[$i]['id'] ?>" class="action-link delete-link">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>