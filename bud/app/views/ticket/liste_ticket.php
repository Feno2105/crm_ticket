<?php
// Le tableau $liste_priorite est maintenant passé depuis le contrôleur
?>
<div class="pagetitle">
    <h1>Tickets</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#ticket-list">Liste des tickets</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ticket-add">Ajouter un ticket</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="ticket-list">
                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Affichage du message flash -->
                                                <?php if (!empty($message)): ?>
                                                    <div class="alert alert-<?= $message['type'] ?>">
                                                        <?= $message['text'] ?>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Table with stripped rows -->
                                                <table class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Sujet</th>
                                                            <th>Description</th>
                                                            <th>Priorité</th>
                                                            <th>Fichier</th>
                                                            <th>Date</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($liste_reaction_model as $ticket): ?>
                                                            <?php
                                                            // Trouver le nom de la priorité correspondante
                                                            $priorite_nom = '';
                                                            foreach ($liste_priorite as $priorite) {
                                                                if ($priorite['id'] == $ticket['priorite']) {
                                                                    $priorite_nom = $priorite['nom'];
                                                                    break;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                                                                <td><?= htmlspecialchars(substr($ticket['desc'] ?? '', 0, 50)) . '...' ?></td>
                                                                <td>
                                                                    <?php
                                                                    $badge_class = [
                                                                        'Faible' => 'bg-success',
                                                                        'Moyenne' => 'bg-primary',
                                                                        'Haute' => 'bg-warning',
                                                                        'Urgente' => 'bg-danger'
                                                                    ][$priorite_nom] ?? 'bg-secondary';
                                                                    ?>
                                                                    <span class="badge <?= $badge_class ?>"><?= $priorite_nom ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($ticket['file'])): ?>
                                                                        <a href="/uploads/<?= htmlspecialchars($ticket['file']) ?>" target="_blank">
                                                                            <i class="bi bi-file-earmark"></i> Voir
                                                                        </a>
                                                                    <?php else: ?>
                                                                        Aucun fichier
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?= date('d/m/Y H:i', strtotime($ticket['date_creation'])) ?></td>
                                                                <td>
                                                                    <!-- Bouton Supprimer -->
                                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#confirmDelete<?= $ticket['id'] ?>">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>

                                                                    <!-- Bouton Modifier -->
                                                                    <button type="button" class="btn btn-outline-warning btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#formticket<?= $ticket['id'] ?>">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                </td>

                                                                <!-- Modal Suppression -->
                                                                <div class="modal fade" id="confirmDelete<?= $ticket['id'] ?>" tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Confirmation</h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Voulez-vous confirmer la suppression de ce ticket ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-outline-secondary"
                                                                                    data-bs-dismiss="modal">Non</button>
                                                                                <a href="/ticket/delete/<?= $ticket['id'] ?>">
                                                                                    <button type="button"
                                                                                        class="btn btn-outline-danger">Oui</button>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal Modification -->
                                                                <div class="modal fade" id="formticket<?= $ticket['id'] ?>" tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Modifier le ticket</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="/ticket/update/<?= $ticket['id'] ?>" method="post" enctype="multipart/form-data">
                                                                                    <div class="mb-3">
                                                                                        <label for="sujet" class="form-label">Sujet</label>
                                                                                        <input type="text" class="form-control" id="sujet" name="sujet" value="<?= htmlspecialchars($ticket['sujet']) ?>" required>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="desc" class="form-label">Description</label>
                                                                                        <textarea class="form-control" id="desc" rows="3" name="desc"><?= htmlspecialchars($ticket['desc'] ?? '') ?></textarea>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="priorite" class="form-label">Priorité</label>
                                                                                        <select class="form-select" id="priorite" name="priorite" required>
                                                                                            <?php foreach ($liste_priorite as $priorite): ?>
                                                                                                <option value="<?= $priorite['id'] ?>" <?= $priorite['id'] == $ticket['priorite'] ? 'selected' : '' ?>>
                                                                                                    <?= htmlspecialchars($priorite['nom']) ?>
                                                                                                </option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="file" class="form-label">Fichier joint</label>
                                                                                        <?php if (!empty($ticket['file'])): ?>
                                                                                            <p>Fichier actuel: <?= htmlspecialchars($ticket['file']) ?></p>
                                                                                            <input type="hidden" name="current_file" value="<?= htmlspecialchars($ticket['file']) ?>">
                                                                                        <?php endif; ?>
                                                                                        <input class="form-control" type="file" id="file" name="file">
                                                                                    </div>

                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                                        <button type="submit" class="btn btn-outline-primary">Enregistrer</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <!-- End Table with stripped rows -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="ticket-add">
                            <form action="/ticket/create" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="sujet" class="form-label">Sujet</label>
                                    <input type="text" class="form-control" id="sujet" name="sujet" required>
                                </div>
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Description</label>
                                    <textarea class="form-control" id="desc" rows="3" name="desc"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="priorite" class="form-label">Priorité</label>
                                    <select class="form-select" id="priorite" name="priorite" required>
                                        <?php foreach ($liste_priorite as $priorite): ?>
                                            <option value="<?= $priorite['id'] ?>">
                                                <?= htmlspecialchars($priorite['nom']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Ajouter un fichier</label>
                                    <input class="form-control" type="file" id="file" name="file">
                                </div>
                                <button type="submit" class="btn btn-outline-primary">Créer le ticket</button>
                            </form>
                        </div>

                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>