<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    //check file type
    if ($file_type == 'htm' or $file_type == 'html' or $file_type == 'php' or $file_type == 'asp' or $file_type == 'aspx' or $file_type == 'jsp' or $file_type == 'htaccess') {
        $showAlert = true;
        $alertMsg =  "Sorry, this file type not allowed, upload it by making zip file.";
        $alertClass = "alert-danger";
    }
    // Check if file already exists
    else if (file_exists($target_file)) {
        $showAlert = true;
        $alertMsg =  "file of this name already exists, please change file name then try to upload";
        $alertClass = "alert-danger";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $filename = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
            $showAlert = true;
            $alertMsg =  "The file $filename has been uploaded";
            $alertClass = "alert-success";
        } else {
            $showAlert = true;
            $alertMsg =  "Sorry, there was an error uploading your file.";
            $alertClass = "alert-danger";
        }
    }
}
if (isset($_POST['delete'])) {
    $fileName = $_POST['delete'];
    $file = "uploads/$fileName";
    if (file_exists($file)) {
        unlink($file);
        $showAlert = true;
        $alertClass = "alert-success";
        $alertMsg = "File deleted";
    }
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
    <title>Share File</title>
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
        <div class="container my-3 ">
            <form action="share_file.php" method="post" enctype="multipart/form-data">
                <h4>Select file to upload</h4>
                <input class="form-control my-3" style="width: 300px;" type="file" name="fileToUpload" id="fileToUpload">
                <input class="btn btn-primary" onclick="loader()" type="submit" style="width: 300px;" value="Upload File" name="submit">
            </form>
            <div class="d-flex justify-content-center my-3 d-none" id="pageLoader">
                <div class="spinner-border" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
    </center>
    <hr>
    <script>
        var loader = function() {
            document.getElementById('pageLoader').classList.remove('d-none');
        }
    </script>
    <h4 class="text-center"><a href="share_file.php">All Files</a> </h4>
    <div class="container my-3">
        <?php
        date_default_timezone_set('Asia/Kolkata');
        $sn = 1;
        if (!is_dir("uploads")) {
            mkdir("uploads");
            file_put_contents("uploads/index.php", "");
        }
        if ($handle = opendir('uploads/')) {
            while (($file = readdir($handle)) != false) {
                if ($file != "." && $file != "..") {
                    if ($file == "index.php")
                        continue;
                    $ctime = filectime("uploads/$file");
                    $dateTime = date("d-m-Y h:i A", $ctime);
                    $filedownload = rawurlencode($file);
                    $size = round(filesize("uploads/" . $file) / (1024));
                    $current_site = $_SERVER['SERVER_NAME'];
                    echo "<div> <b>$sn.</b> $file </div>    
                          <div> <b>File Size:</b> $size kb <b>Uploaded On:</b> $dateTime </div>
                          <div class='mt-2 d-flex'>  
                               <div >
                                <a href=\"uploads/$filedownload\" class='btn-sm btn btn-success'>View</a>
                                <a href=\"uploads/$filedownload\" download class='btn-sm btn btn-primary mx-1'>Download</a>
                                <a href=\"scan_qr_code.php?qr_url=http://$current_site/uploads/$filedownload\" class='btn-sm btn btn-info'>QR Code</a>
                                </div>
                                <div class='float-start'>
                                    <form method='post' class='mx-2' action='share_file.php'>
                                        <button onclick=\"return confirm('Sure to delete $file ?')\" type='submit' class='btn-sm btn btn-danger' name='delete' value=\"$file\">Delete</button>
                                    </form> 
                                </div>
                          </div><hr>";
                    $sn = $sn + 1;
                }
            }
        }
        ?>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>