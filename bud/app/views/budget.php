<div class="col-12">
    <div class="card top-selling overflow-auto">

        <div class="card-body pb-0">
            <h5 class="card-title">Valider les<span> Budget</span></h5>

            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">libelle</th>
                        <th scope="col">Total Vendu</th>
                        <th scope="col">Revenu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($budgets as $moinsVendue) { ?>
                        <tr>
                            <!-- <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th> -->
                            <td><?php echo $moinsVendue['libele']; ?></td>
                            <td><?php echo $moinsVendue['prevision']; ?></td>
                            <td class="fw-bold"><?php echo ($moinsVendue['prevision']); ?></td>
                            <td><a href="/bud?id=<?php echo $moinsVendue['idB']; ?>"><button class="btn btn-primary w-100"
                                        type="submit">Valider</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>

    </div>