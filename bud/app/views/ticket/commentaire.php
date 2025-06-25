<!-- ======= Page Title ======= -->
<div class="pagetitle">
    <h1>Produits par Client</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Produits</li>
            <li class="breadcrumb-item active">Par Client</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Formulaire de recherche -->
                    <?php if (!isset($_GET['client_id']) || $_GET['client_id'] == ''): ?>
                    <form method="get" action="/commentaire/avis" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="clientSelect" class="form-label">Rechercher un client</label>
                                <select class="form-select" id="clientSelect" name="client_id">
                                    <option value="">-- Tous les clients --</option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client['id_client'] ?>">
                                            <?= htmlspecialchars($client['nom']) ?> 
                                            (<?= htmlspecialchars($client['email']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filtrer
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>

                    <!-- Liste des clients -->
                    <?php if (!isset($_GET['client_id']) || $_GET['client_id'] == ''): ?>
                        <div class="mb-5">
                            <h5 class="card-title">Liste complète des clients</h5>
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clients as $client): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($client['nom']) ?></td>
                                                <td><?= htmlspecialchars($client['email']) ?></td>
                                                <td><?= htmlspecialchars($client['telephone']) ?></td>
                                                <td>
                                                    <a href="/commentaire/avis?client_id=<?= $client['id_client'] ?>" class="btn btn-primary">
                                                        Voir les avis
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Liste des produits (version div) -->
                    <?php if (isset($_GET['client_id']) && $_GET['client_id'] != ''): ?>
                        <?php 
                        $selectedClient = null;
                        foreach ($clients as $client) {
                            if ($client['id_client'] == $_GET['client_id']) {
                                $selectedClient = $client;
                                break;
                            }
                        }
                        ?>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">Produits achetés par <?= htmlspecialchars($selectedClient['nom']) ?></h5>
                                <a href="/commentaire" class="btn btn-outline-secondary">Changer de client</a>
                            </div>
                            
                            <?php if (!empty($products)): ?>
                                <div class="row">
                                    <?php foreach ($products as $produit): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= htmlspecialchars($produit['nom_produit']) ?></h5>
                                                    
                                                   <!-- Évaluation et Commentaire -->
                                                <div class="mb-3">
                                                    <label class="form-label">Évaluation</label>
                                                    <div class="rating-input mb-2">
                                                        <?php 
                                                        $note = $produit['note'] ?? 0;
                                                        for ($i = 1; $i <= 5; $i++): ?>
                                                            <i class="bi bi-star<?= $i <= $note ? '-fill text-warning' : '' ?>" 
                                                               data-value="<?= $i ?>" style="cursor: pointer; font-size: 1.2rem;"></i>
                                                        <?php endfor; ?>
                                                        <input type="hidden" name="note" value="<?= $note ?>">
                                                    </div>
                                                    <small class="text-muted"><?= number_format($note, 1) ?>/5</small>
                                                </div>
                                                        
                                                <!-- Commentaire -->
                                                <div class="mb-3">
                                                    <label class="form-label">Commentaire</label>
                                                    <?php if (!empty($produit['commentaire'])): ?>
                                                        <div class="alert alert-info p-2"><?= htmlspecialchars($produit['commentaire']) ?></div>
                                                    <?php else: ?>
                                                        <div class="alert alert-light p-2">Aucun commentaire</div>
                                                    <?php endif; ?>
                                                </div>
                                                    
                                                <!-- Bouton d'action -->
                                                <button type="button" class="btn btn-sm btn-outline-primary w-100" 
                                                        data-bs-toggle="modal" data-bs-target="#editEvaluation<?= $produit['id_produit'] ?>">
                                                    <i class="bi bi-pencil"></i> Modifier l'évaluation
                                                </button>
                                                    
                                                <!-- Modal d'édition -->
                                                <div class="modal fade" id="editEvaluation<?= $produit['id_produit'] ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier l'évaluation</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="/commentaire/evaluation" method="post">
                                                                <input type="hidden" name="id_ticket_produit" value="<?= $produit['id_ticket'] ?>">
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Note</label>
                                                                        <div class="rating-input">
                                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                                <i class="bi bi-star<?= $i <= $note ? '-fill text-warning' : '' ?>" 
                                                                                   data-value="<?= $i ?>" style="cursor: pointer; font-size: 1.5rem;"></i>
                                                                            <?php endfor; ?>
                                                                            <input type="hidden" name="note" value="<?= $note ?>">
                                                                            <input type="hidden" name="note" value="<?= $note ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="commentaire<?= $produit['id_produit'] ?>" class="form-label">Commentaire</label>
                                                                        <textarea class="form-control" id="commentaire<?= $produit['id_commentaire'] ?>" 
                                                                                  name="commentaire" rows="3"><?= htmlspecialchars($produit['commentaire'] ?? '') ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                <div class="alert alert-info">Aucun produit trouvé pour ce client.</div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des étoiles de notation
    document.querySelectorAll('.rating-input i').forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const container = this.parentElement;
            const input = container.querySelector('input[name="note"]');
            
            // Mettre à jour les étoiles visuelles
            container.querySelectorAll('i').forEach((s, index) => {
                if (index < value) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill', 'text-warning');
                } else {
                    s.classList.remove('bi-star-fill', 'text-warning');
                    s.classList.add('bi-star');
                }
            });
            
            // Mettre à jour la valeur cachée
            input.value = value;
        });
    });
});
</script>