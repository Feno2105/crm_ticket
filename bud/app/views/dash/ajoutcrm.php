<div class="col-12">
    <div class="card top-selling overflow-auto">

        <div class="card-body pb-0">
            <h5 class="card-title">Details Produits</h5>

            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Nom Produit</th>
                        <th scope="col">Categorie Produit</th>
                        <th scope="col">Marque</th>
                        <th scope="col">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th> -->
                        <td><?php echo $products['nom_produit']; ?></td>
                        <td><?php echo $products['nom_categorie']; ?></td>
                        <td><?php echo $products['marque']; ?></td>
                        <td class="fw-bold"><?php echo ($products['prix']); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="/dashboard/ajoutcrm" method="post">
    <div class="col-12">
        <label for="crm" class="form-label">Prix du CRM</label>
        <input type="number" class="form-control" id="crm" placeholder="Prix CRM" required name="prix">
    </div>
    <div class="col-12">
        <label for="mois" class="form-label">Mois</label>
        <input type="number" class="form-control" id="mois" placeholder="Mois" required name="mois">
    </div>
    <div class="col-12">
        <label for="annee" class="form-label">Annee</label>
        <input type="number" class="form-control" id="annee" placeholder="Annee" required name="annee">
    </div>
    <div class="col-12">
        <select name="crm" id="">
            <?php foreach ($reactions as $reaction) { ?>
                <option value="<?php echo $reaction['id_reaction']; ?>"><?php echo $reaction['nom_reaction']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="div-submit-form">
        <button type="submit">Valider</button>
    </div>
</form>