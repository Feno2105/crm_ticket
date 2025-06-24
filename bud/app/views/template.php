<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="/assets/css/style.css" rel="stylesheet">
    <!-- Style du loader -->
    <link rel="stylesheet" href="/assets/css/mycss.css">
</head>

<body>
    <!-- Loader qui couvre toute la page -->
    <div id="global-loader">
        <div class="loader"></div>
    </div>
    <main id="" class="">
        <?php include($page . '.php'); ?>
    </main>
</body>

<!-- Vendor JS Files -->
<script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/chart.js/chart.umd.js"></script>
<script src="/assets/vendor/echarts/echarts.min.js"></script>
<script src="/assets/vendor/quill/quill.js"></script>
<script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/assets/js/main.js"></script>
<!-- Script pour masquer le loader -->
<script>
    // Cache le loader quand tout est chargé
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');

        // Optionnel: Supprime le loader après l'animation
        setTimeout(function() {
            document.getElementById('global-loader').remove();
        }, 500);
    });
</script>

</html>