<div class="pagetitle">
    <h1>Clients</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Client</li>
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
                                data-bs-target="#client-list">List</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#client-add">Add</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="client-list">
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
                                                            <th>Email</th>
                                                            <th>telephone</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($clients); $i++) { ?>
                                                            <tr>
                                                                <td><?= $clients[$i]['nom'] ?></td>
                                                                <td><?= $clients[$i]['email'] ?></td>
                                                                <td><?= $clients[$i]['telephone'] ?></td>
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
                                                                                    href="/CRM/delete-client?id_client=<?= $clients[$i]['id_client'] ?>">
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
                                                                                <h5 class="modal-title">Modified client
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="/CRM/update-client"
                                                                                    method="post">
                                                                                    <input type="hidden" name="id_client"
                                                                                        value="<?= $clients[$i]['id_client'] ?>">
                                                                                    <div class="mb-3">
                                                                                        <label for="name"
                                                                                            class="form-label">Name</label>
                                                                                        <input type="text"
                                                                                            class="form-control" id="name"
                                                                                            placeholder="Jean Dupont"
                                                                                            name="name"
                                                                                            value="<?= $clients[$i]['nom'] ?>">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="email"
                                                                                            class="form-label">Email</label>
                                                                                        <input type="email"
                                                                                            class="form-control" id="email"
                                                                                            placeholder="client@gmail.com"
                                                                                            name="email"
                                                                                            value="<?php if ($clients[$i]['email'] == 'aucun') {
                                                                                                echo "";
                                                                                            } else {
                                                                                                echo $clients[$i]['email'];
                                                                                            } ?>">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="tel"
                                                                                            class="form-label">Tel</label>
                                                                                        <input type="Tel"
                                                                                            class="form-control" id="tel"
                                                                                            placeholder="0341773500"
                                                                                            name="tel"
                                                                                            value="<?php if ($clients[$i]['telephone'] == 'aucun') {
                                                                                                echo "";
                                                                                            } else {
                                                                                                echo $clients[$i]['telephone'];
                                                                                            } ?>">
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
                                                                                            <?php for ($j = 0; $j < count($client_categories); $j++) { ?>
                                                                                                <option
                                                                                                    value="<?= $client_categories[$j]['id_categorie'] ?>"
                                                                                                    <?php if ($client_categories[$j]['id_categorie'] == $clients[$i]['id_categorie']) { ?>
                                                                                                        selected <?php } ?>>
                                                                                                    <?= $client_categories[$j]['nom_categorie'] ?>
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

                        <div class="tab-pane fade profile-edit pt-3" id="client-add">
                            <form action="/CRM/add-client" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Jean Dupont"
                                        name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="client@gmail.com"
                                        name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="tel" class="form-label">Tel</label>
                                    <input type="Tel" class="form-control" id="tel" placeholder="0341773500" name="tel">
                                </div>
                                <div class="mb-3">
                                    <label for="id_categorie" class="form-label">Category</label>
                                    <select class="form-select" aria-label="Default select example" name="id_categorie"
                                        id="id_categorie">
                                        <option selected value="">Category</option>
                                        <?php for ($i = 0; $i < count($client_categories); $i++) { ?>
                                            <option value="<?= $client_categories[$i]['id_categorie'] ?>">
                                                <?= $client_categories[$i]['nom_categorie'] ?>
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