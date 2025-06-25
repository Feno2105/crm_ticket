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
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php if (!isset($_GET['client_id'])): ?>
                        <!-- Étape 1 : Sélection du client -->
                        <h5 class="card-title">Sélectionnez un client</h5>
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
                                                <a href="?client_id=<?= $client['id_client'] ?>" class="btn btn-primary">
                                                    Voir les avis
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- Étape 2 : Liste des produits du client sélectionné -->
                        <?php 
                        $selectedClient = null;
                        foreach ($clients as $client) {
                            if ($client['id_client'] == $_GET['client_id']) {
                                $selectedClient = $client;
                                break;
                            }
                        }
                        ?>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Produits achetés par <?= htmlspecialchars($selectedClient['nom']) ?></h5>
                            <a href="?" class="btn btn-outline-secondary">Changer de client</a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Date d'achat</th>
                                        <th>Évaluation</th>
                                        <th>Commentaire</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produitsClient as $produit): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($produit['nom_produit']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($produit['date_achat'])) ?></td>
                                            <td>
                                                <div class="rating">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="bi bi-star<?= $i <= $produit['note'] ? '-fill text-warning' : '' ?>"></i>
                                                    <?php endfor; ?>
                                                    (<?= $produit['note'] ?>/5)
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($produit['commentaire'])): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="popover" 
                                                            title="Commentaire" data-bs-content="<?= htmlspecialchars($produit['commentaire']) ?>">
                                                        Voir commentaire
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted">Aucun commentaire</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" data-bs-target="#editEvaluation<?= $produit['id_achat'] ?>">
                                                    <i class="bi bi-pencil"></i> Modifier
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal pour modifier l'évaluation -->
                                        <div class="modal fade" id="editEvaluation<?= $produit['id_achat'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modifier l'évaluation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="/CRM/update-evaluation" method="post">
                                                        <input type="hidden" name="id_achat" value="<?= $produit['id_achat'] ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Note</label>
                                                                <div class="rating-input">
                                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                        <i class="bi bi-star<?= $i <= $produit['note'] ? '-fill text-warning' : '' ?>" 
                                                                           data-value="<?= $i ?>" style="cursor: pointer; font-size: 1.5rem;"></i>
                                                                    <?php endfor; ?>
                                                                    <input type="hidden" name="note" value="<?= $produit['note'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="commentaire<?= $produit['id_achat'] ?>" class="form-label">Commentaire</label>
                                                                <textarea class="form-control" id="commentaire<?= $produit['id_achat'] ?>" 
                                                                          name="commentaire" rows="3"><?= htmlspecialchars($produit['commentaire']) ?></textarea>
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
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script pour les étoiles de notation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (el) {
        return new bootstrap.Popover(el);
    });
    
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