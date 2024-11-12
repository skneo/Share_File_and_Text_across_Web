<?php
// session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="index.php"><img src="sharelogo.png" alt="shareapps" width="40" height="40"></a>
        <a class="navbar-brand ms-2" href="home.php">Home </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="active nav-link " aria-current="page" href="share_file.php">Share File</a>
                </li>
                <li class="nav-item">
                    <a class="active nav-link " aria-current="page" href="share_text.php">Share Text</a>
                </li>
            </ul>
            <?php
            $current_site = $_SERVER['SERVER_NAME'];
            echo "<a class='btn btn-sm btn-primary me-2' aria-current='page' href='scan_qr_code.php?qr_url=http://$current_site'>QR Code</a>";
            ?>
            <a class="btn btn-info me-2 btn-sm" aria-current="page" href="change_password.php">Change Password</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>
<style>
    @media only screen and (min-width: 960px) {
        .navbar .navbar-nav .nav-item .nav-link {
            padding: 0 0.5em;
        }

        .navbar .navbar-nav .nav-item:not(:last-child) .nav-link {
            border-right: 1px solid #f8efef;
        }
    }
</style>