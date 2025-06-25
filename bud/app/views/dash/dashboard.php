<form action="/dashboard" method="post">
    <select name="product" id="">
        <?php foreach ($products as $product) { ?>
            <option value="<?php echo $product['id_produit']; ?>"><?php echo $product['nom_produit']; ?></option>
        <?php } ?>
    </select>
    <div class="col-12">
        <label for="annee" class="form-label">Annee</label>
        <input type="number" class="form-control" id="annee" placeholder="Annee" required name="annee">
    </div>
    <div class="div-submit-form">
        <button type="submit">Valider</button>
    </div>
</form>
<div id="reportsChart"></div>

<form action="/dashboard" method="post">
    <div class="col-12">
        <label for="annee" class="form-label">Annee</label>
        <input type="number" class="form-control" id="annee" placeholder="Annee" required name="annee">
    </div>
    <div class="div-submit-form">
        <button type="submit">Valider</button>
    </div>
</form>

<?php if (isset($quantity)) { ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: <?php echo json_encode($name[0]) ?>,
                    data: <?php echo json_encode($quantity); ?>,
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '55%',
                    }
                },
                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", 
                                "Jul", "Aoû", "Sep", "Oct", "Nov", "Déc"],
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: "Quantité"
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " unités"
                        }
                    }
                }
            }).render();
        });
    </script>
<?php } ?>
<?php if (isset($moinsVendues)) { ?>

    <!-- Top Selling -->
    <div class="col-12">
        <div class="card top-selling overflow-auto">

            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
            </div>

            <div class="card-body pb-0">
                <h5 class="card-title">Low Selling <span>| Today</span></h5>

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Nom Produit</th>
                            <th scope="col">Total Vendu</th>
                            <th scope="col">Revenu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($moinsVendues as $moinsVendue) { ?>
                            <tr>
                                <!-- <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th> -->
                                <td><?php echo $moinsVendue['nom_produit']; ?></td>
                                <td><?php echo $moinsVendue['total_vendue']; ?></td>
                                <td class="fw-bold"><?php echo ($moinsVendue['total_vendue'] * $moinsVendue['prix']); ?></td>
                                <td><a href="dashboard/crm?id=<?php echo $moinsVendue['id_produit']; ?>"><button
                                            class="btn btn-primary w-100" type="submit">Ajout
                                            Reaction</button></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div><!-- End Top Selling -->
<?php } ?>

<?php if (isset($plusVendues)) { ?>
    <!-- Top Selling -->
    <div class="col-12">
        <div class="card top-selling overflow-auto">

            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
            </div>

            <div class="card-body pb-0">
                <h5 class="card-title">Top Selling <span>| Today</span></h5>

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Nom Produit</th>
                            <th scope="col">Total Vendu</th>
                            <th scope="col">Revenu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plusVendues as $plusVendue) { ?>
                            <tr>
                                <!-- <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th> -->
                                <td><?php echo $plusVendue['nom_produit']; ?></td>
                                <td><?php echo $plusVendue['total_vendue']; ?></td>
                                <td class="fw-bold"><?php echo ($plusVendue['total_vendue'] * $plusVendue['prix']); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <!-- End Top Selling -->
<?php } ?>