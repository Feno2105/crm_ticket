<?php

$type_reaction_list = ['positive', 'negative', 'neutre'];
?>
<div class="pagetitle">
      <h1>Reaction</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">CRM</li>
          <li class="breadcrumb-item active">Reaction</li>
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
                                data-bs-target="#reaction-list">List</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reaction-add">Add</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="reaction-list">
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
                                                            <th>type_reaction</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($liste_reaction_model); $i++) { ?>
                                                                                    <tr>
                                                                                        <td><?= $liste_reaction_model[$i]['nom_reaction'] ?> </td>
                                                                                        <td><?= $liste_reaction_model[$i]['type_reaction'] ?></td>
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
                                                                                                            href="/CRM/delete-reaction?id_reaction=<?= $liste_reaction_model[$i]['id_reaction'] ?>">
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
                                                                                                        <form action="/CRM/update-reaction"
                                                                                                            method="post">
                                                                                                            <input type="hidden" name="reaction_id"
                                                                                                                value="<?= $liste_reaction_model[$i]['id_reaction'] ?>">
                                                                                                            <div class="mb-3">
                                                                                                                <label
                                                                                                                    for="exampleFormControlTextarea1"
                                                                                                                    class="form-label">Modified</label>
                                                                                                                <textarea class="form-control"
                                                                                                                    id="exampleFormControlTextarea1"
                                                                                                                    rows="3"
                                                                                                                    placeholder="Description"
                                                                                                                    name="description"><?= $liste_reaction_model[$i]['nom_reaction'] ?></textarea>
                                                                                                            </div>
                                                                                                            <div class="mb-3">
                                                                                                                <select class="form-select"
                                                                                                                    aria-label="Default select example" name="type_reaction">
                                                                                                                    <option selected>Type de
                                                                                                                        reaction</option>
                                                                                                                    <?php for ($j = 0; $j < count($type_reaction_list); $j++) { ?>
                                                                                                                                                <option
                                                                                                                                                    value="<?= $type_reaction_list[$j] ?>"
                                                                                                                                                    <?php if ($liste_reaction_model[$i]['type_reaction'] == $type_reaction_list[$j]) { ?>
                                                                                                                                                                                selected
                                                                                                                                                                                <?php
                                                                                                                                                    } ?>>
                                                                                                                                                    <?= $type_reaction_list[$j] ?>
                                                                                                                                                </option>
                                                                                                                    <?php } ?>
                                                                                                                </select>
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

                        <div class="tab-pane fade profile-edit pt-3" id="reaction-add">
                            <form action="/CRM/add-reaction" method="post">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Add new reaction</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        placeholder="Description" name="description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" aria-label="Default select example" name="type_reaction">
                                        <option selected>Type de reaction</option>
                                        <?php for ($i = 0; $i < count($type_reaction_list); $i++) { ?>
                                                                    <option value="<?= $type_reaction_list[$i] ?>"><?= $type_reaction_list[$i] ?>
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