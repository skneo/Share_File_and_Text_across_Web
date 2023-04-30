<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
include 'uploads_dir.php';
$file = $_GET['file'];
$file_path = "$uploads_dir/$file"
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="sharelogo.png">
    <title>Preview File </title>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container mb-3">
        <a href="share_file.php" class="btn btn-primary btn-sm my-1">&larr; Back</a>
        <object data="<?php echo $file_path ?>" type="application/pdf" width="100%" height="1080px">
            <p>Your web browser doesn't have a PDF plugin. Instead you can <a href="<?php echo $file_path ?>">click here to download the file.</a></p>
        </object>

    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>

</html>