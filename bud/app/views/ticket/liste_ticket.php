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
                                                    <!-- En-tête du tableau -->
                                                    <thead>
                                                        <tr>
                                                            <th>Sujet</th>
                                                            <th>Description</th>
                                                            <th>Priorité</th>
                                                            <th>Statut</th>
                                                            <th>Assignation</th>
                                                            <th>Fichier</th>
                                                            <th>Date</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php foreach ($liste_reaction_model as $ticket): ?>
                                                            <tr>
                                                                <td><?= $ticket['sujet'] ?? 'Non spécifié' ?></td>
                                                                <td><?= substr($ticket['desc'] ?? 'Aucune description', 0, 50) . '...' ?></td>
                                                                <td>
                                                                    <?php
                                                                    $priorite_nom = '';
                                                                    foreach ($liste_priorite as $priorite) {
                                                                        if ($priorite['id'] == $ticket['priorite']) {
                                                                            $priorite_nom = $priorite['nom'];
                                                                            break;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <span class="badge bg-<?=
                                                                                            match ($priorite_nom) {
                                                                                                'Faible' => 'success',
                                                                                                'Moyenne' => 'primary',
                                                                                                'Haute' => 'warning',
                                                                                                'Urgente' => 'danger',
                                                                                                default => 'secondary'
                                                                                            }
                                                                                            ?>">
                                                                        <?= $priorite_nom ?>
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-<?=
                                                                                            match ($ticket['statut_nom'] ?? '') {
                                                                                                'Nouveau' => 'info',
                                                                                                'En cours' => 'primary',
                                                                                                'Résolu' => 'success',
                                                                                                'Fermé' => 'secondary',
                                                                                                default => 'light'
                                                                                            }
                                                                                            ?>">
                                                                        <?= $ticket['statut_nom'] ?? 'Inconnu' ?>
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($ticket['assignment'])): ?>
                                                                        <?= $ticket['assignment']['agent_nom'] ?? 'Inconnu' ?>
                                                                        <?= $ticket['assignment']['agent_prenom'] ?? '' ?>
                                                                    <?php else: ?>
                                                                        Non assigné
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($ticket['file'])): ?>
                                                                        <a href="/uploads/<?= $ticket['file'] ?>" target="_blank">
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

                                                                    <!-- Bouton Assigner/Changer assignation -->
                                                                    <?php if (empty($ticket['assignment'])): ?>
                                                                        <button type="button" class="btn btn-outline-info btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#assignTicket<?= $ticket['id'] ?>">
                                                                            <i class="bi bi-person-plus"></i> Assigner
                                                                        </button>
                                                                    <?php else: ?>
                                                                        <button type="button" class="btn btn-outline-success btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#changeAssignment<?= $ticket['id'] ?>">
                                                                            <i class="bi bi-people"></i> Réassigner
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>

                                                            <!-- Modal d'assignation -->
                                                            <div class="modal fade" id="assignTicket<?= $ticket['id'] ?>" tabindex="-1">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Assigner le ticket</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="/assignment/create" method="post">
                                                                                <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">

                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Statut actuel</label>
                                                                                    <input type="text" class="form-control"
                                                                                        value="<?= $ticket['statut_nom'] ?? 'Inconnu' ?>"
                                                                                        readonly>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Agent</label>
                                                                                    <select class="form-select" name="agent_id" required>
                                                                                        <?php
                                                                                        // Note: Vous devrez récupérer la liste des agents depuis votre modèle
                                                                                        // Par exemple: $agents = $assignmentModel->getAllAgents();
                                                                                        // Pour cet exemple, je suppose que vous avez accès à $liste_agents
                                                                                        foreach ($liste_agents ?? [] as $agent): ?>
                                                                                            <option value="<?= $agent['id'] ?>">
                                                                                                <?= $agent['nom'] ?> <?= $agent['prenom'] ?>
                                                                                            </option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                                    <button type="submit" class="btn btn-primary">Assigner</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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