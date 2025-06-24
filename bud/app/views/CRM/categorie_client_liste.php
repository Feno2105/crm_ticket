<div class="pagetitle">
    <h1>Clients</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Clients</li>
            <li class="breadcrumb-item active">Category</li>
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
                                data-bs-target="#cat-client-list">List</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cat-client-add">Add</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="cat-client-list">
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
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($categorie_client_liste); $i++) { ?>
                                                                        <tr>
                                                                            <td><?= $categorie_client_liste[$i]['nom_categorie'] ?>
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
                                                                                                href="/CRM/delete-categorie-client?id_categorie_client=<?= $categorie_client_liste[$i]['id_categorie'] ?>">
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
                                                                                            <h5 class="modal-title">Vertically Centered
                                                                                            </h5>
                                                                                            <button type="button" class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <form action="/CRM/update-categorie-client"
                                                                                                method="post">
                                                                                                <input type="hidden" name="id_categorie"
                                                                                                    value="<?= $categorie_client_liste[$i]['id_categorie'] ?>">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        for="exampleFormControlTextarea1"
                                                                                                        class="form-label">Modified</label>
                                                                                                    <textarea class="form-control"
                                                                                                        id="exampleFormControlTextarea1"
                                                                                                        rows="3"
                                                                                                        placeholder="Description"
                                                                                                        name="description"><?= $categorie_client_liste[$i]['nom_categorie'] ?></textarea>
                                                                                                </div>

                                                                                                <div class="modal-footer">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-outline-secondary"
                                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                                    <button type="submit"
                                                                                                        class="btn btn-outline-primary">Submit</button>
                                                                                                </div>
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

                        <div class="tab-pane fade profile-edit pt-3" id="cat-client-add">
                            <form action="/CRM/add-categorie-client" method="post">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Add new product
                                        category</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        placeholder="Description" name="description"></textarea>
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