<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <link rel="shortcut icon" type="image/x-icon" href="sharelogo.png">
    <title>Share File and Text</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 ">
                    <div class="card-body">
                        <h5 class="card-title text-center text-success">Share File</h5>
                        <p class="card-text text-left">Share file over web</p>
                        <a href="share_file.php" class="btn btn-primary w-100">Share File</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 ">
                    <div class="card-body">
                        <h5 class="card-title text-center text-success">Share Text</h5>
                        <p class="card-text text-left">Share Text over web</p>
                        <a href="share_text.php" class="btn btn-primary w-100">Share Text</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>