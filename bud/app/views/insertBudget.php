<?php
// Le tableau $liste_priorite est maintenant passé depuis le contrôleur
?>
<div class="pagetitle">
    <h1>Gestion Budgétaire</h1>
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
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#budget-list">Liste des budgets</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#budget-add-prevision">Ajouter prévision</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#budget-add-realisation">Ajouter réalisation</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <!-- Onglet Liste des budgets -->
                        <div class="tab-pane fade show active profile-overview" id="budget-list">
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

                                                <!-- Tableau des Prévisions -->
                                                <h5 class="card-title">Prévisions budgétaires</h5>
                                                <table class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Libellé</th>
                                                            <th>Montant</th>
                                                            <th>Catégorie</th>
                                                            <th>Date</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php /* Boucle foreach pour les prévisions */ ?>
                                                        <?php foreach ($liste_previsions as $prevision): ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($prevision['libelle']) ?></td>
                                                                <td><?= number_format($prevision['montant'], 2, ',', ' ') ?> €</td>
                                                                <td><?= htmlspecialchars($prevision['categorie']) ?></td>
                                                                <td><?= date('d/m/Y', strtotime($prevision['date'])) ?></td>
                                                                <td>
                                                                    <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPrevision<?= $prevision['id'] ?>">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePrevision<?= $prevision['id'] ?>">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                                <!-- Tableau des Réalisations -->
                                                <h5 class="card-title mt-5">Réalisations budgétaires</h5>
                                                <table class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Libellé</th>
                                                            <th>Montant</th>
                                                            <th>Catégorie</th>
                                                            <th>Date</th>
                                                            <th>Prévision associée</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php /* Boucle foreach pour les réalisations */ ?>
                                                        <?php foreach ($liste_realisations as $realisation): ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($realisation['libelle']) ?></td>
                                                                <td><?= number_format($realisation['montant'], 2, ',', ' ') ?> €</td>
                                                                <td><?= htmlspecialchars($realisation['categorie']) ?></td>
                                                                <td><?= date('d/m/Y', strtotime($realisation['date'])) ?></td>
                                                                <td><?= htmlspecialchars($realisation['prevision_libelle'] ?? 'Non associée') ?></td>
                                                                <td>
                                                                    <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRealisation<?= $realisation['id'] ?>">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRealisation<?= $realisation['id'] ?>">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Onglet Ajout Prévision -->
                        <div class="tab-pane fade profile-edit pt-3" id="budget-add-prevision">
                            <form action="/budget/create-prevision" method="post">
                                <div class="mb-3">
                                    <label for="libelle" class="form-label">Libellé</label>
                                    <input type="text" class="form-control" id="libelle" name="libelle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="montant" class="form-label">Montant</label>
                                    <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categorie" class="form-label">Catégorie</label>
                                    <select class="form-select" id="categorie" name="categorie" required>
                                        <?php /* Boucle foreach pour les catégories */ ?>
                                        <?php foreach ($liste_categories as $categorie): ?>
                                            <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <button type="submit" class="btn btn-outline-primary">Enregistrer la prévision</button>
                            </form>
                        </div>

                        <!-- Onglet Ajout Réalisation -->
                        <div class="tab-pane fade profile-edit pt-3" id="budget-add-realisation">
                            <form action="/budget/create-realisation" method="post">
                                <div class="mb-3">
                                    <label for="libelle" class="form-label">Libellé</label>
                                    <input type="text" class="form-control" id="libelle" name="libelle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="montant" class="form-label">Montant</label>
                                    <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categorie" class="form-label">Catégorie</label>
                                    <select class="form-select" id="categorie" name="categorie" required>
                                        <?php /* Boucle foreach pour les catégories */ ?>
                                        <?php foreach ($liste_categories as $categorie): ?>
                                            <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="prevision_id" class="form-label">Associer à une prévision</label>
                                    <select class="form-select" id="prevision_id" name="prevision_id">
                                        <option value="">Non associé</option>
                                        <?php /* Boucle foreach pour les prévisions */ ?>
                                        <?php foreach ($liste_previsions as $prevision): ?>
                                            <option value="<?= $prevision['id'] ?>"><?= htmlspecialchars($prevision['libelle']) ?> (<?= number_format($prevision['montant'], 2, ',', ' ') ?> €)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-outline-primary">Enregistrer la réalisation</button>
                            </form>
                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>