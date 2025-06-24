<div class="pagetitle">
    <h1>Products</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Products</li>
            <li class="breadcrumb-item active">List/add</li>
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
                                data-bs-target="#product-list">List</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product-add">Add</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="product-list">
                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Table with stripped rows -->
                                                <table class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th data-type="textarea">
                                                                <b>N</b>ame
                                                            </th>
                                                            <th>Marque</th>
                                                            <th>Price</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($products); $i++) { ?>
                                                                                            <tr>
                                                                                                <td><?= $products[$i]['nom_produit'] ?></td>
                                                                                                <td><?= $products[$i]['marque'] ?></td>
                                                                                                <td><?= $products[$i]['prix'] ?></td>
                                                                                                <td><button type="button"
                                                                                                        class="btn btn-outline-primary">See more</button>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <button type="button" class="btn btn-outline-danger"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#confirmDelete<?= $i ?>"> <i
                                                                                                            class="bi bi-trash"></i> </button>
                                                                                                </td>
                                                                                                <div class="modal fade" id="confirmDelete<?= $i ?>"
                                                                                                    tabindex="-1">
                                                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title">Confirmation
                                                                                                                </h5>
                                                                                                                <button type="button" class="btn-close"
                                                                                                                    data-bs-dismiss="modal"
                                                                                                                    aria-label="Close"></button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                Voulez vous confirmer la suppresion ?
                                                                                                            </div>
                                                                                                            <div class="modal-footer">
                                                                                                                <button type="button"
                                                                                                                    class="btn btn-outline-secondary"
                                                                                                                    data-bs-dismiss="modal">Non</button>
                                                                                                                <a
                                                                                                                    href="/CRM/delete-product?id_produit=<?= $products[$i]['id_produit'] ?>">
                                                                                                                    <button type="button"
                                                                                                                        class="btn btn-outline-danger">Oui</button></a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div><!-- End Vertically centered Modal-->
                                                                                                <td>
                                                                                                    <button type="button" class="btn btn-outline-warning"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#verticalycentered<?= $i ?>"><i
                                                                                                            class="bi bi-brush"></i></button>
                                                                                                </td>
                                                                                                <div class="modal fade" id="verticalycentered<?= $i ?>"
                                                                                                    tabindex="-1">
                                                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title">Modified product
                                                                                                                </h5>
                                                                                                                <button type="button" class="btn-close"
                                                                                                                    data-bs-dismiss="modal"
                                                                                                                    aria-label="Close"></button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <form action="/CRM/update-product"
                                                                                                                    method="post">
                                                                                                                    <input type="hidden" name="id_produit"
                                                                                                                        value="<?= $products[$i]['id_produit'] ?>">
                                                                                                                    <div class="mb-3">
                                                                                                                        <label for="name"
                                                                                                                            class="form-label">Name</label>
                                                                                                                        <input type="text"
                                                                                                                            class="form-control" id="name"
                                                                                                                            placeholder="Ex : Peugeot 208"
                                                                                                                            name="name"
                                                                                                                            value="<?= $products[$i]['nom_produit'] ?>">
                                                                                                                    </div>
                                                                                                                    <div class="mb-3">
                                                                                                                        <label for="marque"
                                                                                                                            class="form-label">Marque</label>
                                                                                                                        <input type="text"
                                                                                                                            class="form-control" id="marque"
                                                                                                                            placeholder="Ex : Peugeot"
                                                                                                                            name="marque"
                                                                                                                            value="<?= $products[$i]['marque'] ?>">
                                                                                                                    </div>
                                                                                                                    <div class="mb-3">
                                                                                                                        <label for="prix"
                                                                                                                            class="form-label">Price</label>
                                                                                                                        <input type="number" min="1"
                                                                                                                            class="form-control" id="prix"
                                                                                                                            name="prix" value="<?= $products[$i]['prix'] ?>">
                                                                                                                    </div>
                                                                                                                    <div class="mb-3">
                                                                                                                        <label for="id_categorie"
                                                                                                                            class="form-label">Category</label>
                                                                                                                        <select class="form-select"
                                                                                                                            aria-label="Default select example"
                                                                                                                            name="id_categorie"
                                                                                                                            id="id_categorie">
                                                                                                                            <option value="">
                                                                                                                                Category</option>
                                                                                                                            <?php for ($j = 0; $j < count($product_categories); $j++) { ?>
                                                                                                                                                                <option
                                                                                                                                                                    value="<?= $product_categories[$j]['id_categorie'] ?>"
                                                                                                                                                                    <?php if ($product_categories[$j]['id_categorie'] == $products[$i]['id_categorie']) { ?>
                                                                                                                                                                                                        selected <?php } ?>>
                                                                                                                                                                    <?= $product_categories[$j]['nom_categorie'] ?>
                                                                                                                                                                </option>
                                                                                                                            <?php } ?>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <button type="submit"
                                                                                                                        class="btn btn-outline-primary">Submit</button>
                                                                                                                </form>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div><!-- End Vertically centered Modal-->

                                                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                                <!-- End Table with stripped rows -->

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="product-add">
                            <form action="/CRM/add-product" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Ex : Peugeot 208"
                                        name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="marque" class="form-label">Marque</label>
                                    <input type="text" class="form-control" id="marque" placeholder="Ex : Peugeot"
                                        name="marque">
                                </div>
                                <div class="mb-3">
                                    <label for="prix" class="form-label">Price</label>
                                    <input type="number" min="1" class="form-control" id="prix" placeholder="0341773500"
                                        name="prix">
                                </div>
                                <div class="mb-3">
                                    <label for="id_categorie" class="form-label">Category</label>
                                    <select class="form-select" aria-label="Default select example" name="id_categorie"
                                        id="id_categorie">
                                        <option selected value="">Category</option>
                                        <?php for ($i = 0; $i < count($product_categories); $i++) { ?>
                                                                            <option value="<?= $product_categories[$i]['id_categorie'] ?>">
                                                                                <?= $product_categories[$i]['nom_categorie'] ?>
                                                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </form>
                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>