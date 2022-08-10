<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <link rel="shortcut icon" type="image/x-icon" href="sharelogo.png">
    <title>Scan QR Code</title>
</head>

<body>
    <?php
    include 'header.php';
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <center>
        <div class="container my-3">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['qr_url'])) {
                $qr_url = $_GET['qr_url'];
                $qr_url1 = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qr_url);
            }
            echo "<b>Scan QR Code for</b> <a href='$qr_url'>$qr_url</a><br>";
            ?>

            <br>
            <img src="<?php echo $qr_url1 ?>" alt="qr_code">
        </div>

    </center>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>