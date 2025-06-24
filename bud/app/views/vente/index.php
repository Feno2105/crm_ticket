<div class="pagetitle">
    <h1>Actions</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Vente</li>
        </ol>
    </nav>
</div>

<form action="/vente/add" method="post" id="salesForm">
    <!-- Client -->
    <div class="mb-3">
        <select class="form-select" aria-label="Client" name="id_client" id="id_client" required>
            <option value="" selected disabled>Clients</option>
            <?php foreach ($clients as $client) { ?>
                <option value="<?= $client['id_client'] ?>"><?= $client['email'] ?></option>
            <?php } ?>
        </select>
    </div>
    
    <!-- Produit -->
    <div class="mb-3">
        <select class="form-select" aria-label="Product" id="productSelect" required>
            <option value="" selected disabled>Produits</option>
            <?php foreach ($products as $product) { ?>
                <option value="<?= $product['id_produit'] ?>" data-price="<?= $product['prix'] ?>">
                    <?= $product['nom_produit'] ?> (<?= $product['prix'] ?> Ar)
                </option>
            <?php } ?>
        </select>
    </div>
    
    <!-- Quantité et Date -->
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantité</label>
        <input type="number" class="form-control" id="quantity" value="1" min="1" required>
    </div>
    <div class="mb-3">
        <label for="day" class="form-label">Date</label>
        <input type="date" class="form-control" id="day" name="sale_date" required>
    </div>
    
    <button type="button" class="btn btn-outline-primary" id="addProductBtn">Ajouter</button>
</form>

<!-- Tableau des produits ajoutés -->
<div id="productsTableContainer" style="display: none;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="productsTableBody"></tbody>
    </table>
    
    <div class="d-flex justify-content-between mt-3">
        <button type="button" class="btn btn-outline-danger" id="resetTableBtn">Tout réinitialiser</button>
        <button type="button" class="btn btn-success" id="validateSalesBtn">Valider les achats</button>
    </div>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Confirmez-vous cette vente ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    const quantityInput = document.getElementById('quantity');
    const dayInput = document.getElementById('day');
    const clientSelect = document.getElementById('id_client');
    const addProductBtn = document.getElementById('addProductBtn');
    const productsTableBody = document.getElementById('productsTableBody');
    const productsTableContainer = document.getElementById('productsTableContainer');
    const resetTableBtn = document.getElementById('resetTableBtn');
    const validateSalesBtn = document.getElementById('validateSalesBtn');
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
    const salesForm = document.getElementById('salesForm');
    
    let productsAdded = [];
    
    // Ajouter un produit au tableau
    addProductBtn.addEventListener('click', function() {
        const selectedProduct = productSelect.options[productSelect.selectedIndex];
        if (!selectedProduct.value) {
            alert('Veuillez sélectionner un produit');
            return;
        }
        
        const product = {
            id: selectedProduct.value,
            name: selectedProduct.text.split(' (')[0],
            quantity: parseInt(quantityInput.value),
            unitPrice: parseFloat(selectedProduct.dataset.price),
            day: dayInput.value
        };
        
        product.totalPrice = product.quantity * product.unitPrice;
        productsAdded.push(product);
        updateTable();
        
        // Réinitialiser la sélection
        productSelect.selectedIndex = 0;
        quantityInput.value = 1;
    });
    
    // Mettre à jour le tableau
    function updateTable() {
        productsTableBody.innerHTML = '';
        
        productsAdded.forEach((product, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td>${product.totalPrice} Ar</td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            productsTableBody.appendChild(row);
        });
        
        // Afficher/masquer le tableau
        productsTableContainer.style.display = productsAdded.length ? 'block' : 'none';
        
        // Gérer les boutons de suppression
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                productsAdded.splice(index, 1);
                updateTable();
            });
        });
    }
    
    // Réinitialiser
    resetTableBtn.addEventListener('click', function() {
        productsAdded = [];
        updateTable();
    });
    
    // Valider la vente
    validateSalesBtn.addEventListener('click', function() {
        if (productsAdded.length === 0) {
            alert('Aucun produit ajouté');
            return;
        }
        
        if (!clientSelect.value) {
            alert('Veuillez sélectionner un client');
            return;
        }
        
        confirmModal.show();
    });
    
    // Confirmer l'envoi
    confirmSubmitBtn.addEventListener('click', function() {
        // Créer un champ caché pour les produits
        const productsInput = document.createElement('input');
        productsInput.type = 'hidden';
        productsInput.name = 'products_json';
        productsInput.value = JSON.stringify(productsAdded);
        salesForm.appendChild(productsInput);
        
        // Soumettre le formulaire
        salesForm.submit();
    });
});
</script>