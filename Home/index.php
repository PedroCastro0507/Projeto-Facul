<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descubra UniCuritiba</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <?php include('navbar.php'); ?>


    <div class="container mt-5">
        <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;

            if ($page == 'detail' && $id) {
                include('detail.php');
            } else {
                include('content.php');
            }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
