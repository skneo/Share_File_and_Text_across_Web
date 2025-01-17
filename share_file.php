<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
include 'uploads_dir.php';
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
    if (isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
    ?>
    <center>
        <div class="container mt-2 ">
            <form action="handle_files.php" method="post" enctype="multipart/form-data">
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
    <div class="container my-3 table-responsive">
        <!-- <small>* Files older than 4 hours will be deleted automatically</small> -->
        <table id="table_id" class="table-light table table-striped table-bordered w-100">
            <thead>
                <tr>
                    <th>SN</th>
                    <th style='min-width:300px'>File Name</th>
                    <th style='min-width:80px'>Size </th>
                    <th style='min-width:180px'>Uploaded On</th>
                    <th style='min-width:150px'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                $sn = 1;
                if (!is_dir("$uploads_dir")) {
                    mkdir("$uploads_dir");
                    file_put_contents("$uploads_dir/index.php", "");
                }
                if ($handle = opendir("$uploads_dir/")) {
                    $currentTime = time();
                    while (($file = readdir($handle)) != false) {
                        if ($file != "." && $file != "..") {
                            if ($file == "index.php")
                                continue;
                            $ctime = filectime("$uploads_dir/$file");
                            $timeDiff = $currentTime - $ctime;
                            // if ($timeDiff > 14400) {  // 4 hours = 14400 seconds
                            //     if (unlink("$uploads_dir/$file")) {
                            //         continue;
                            //     }
                            // }
                            $dateTime = date("Y-m-d H:i:s", $ctime);
                            $filedownload = rawurlencode($file);
                            $size = round(filesize("$uploads_dir/" . $file) / (1024));
                            echo "<tr id='row_$sn'>
                                    <td>$sn</td>
                                    <td><a href=\"preview_file.php?file=$filedownload\">$file</a></td>
                                    <td>$size kb</td>
                                    <td>$dateTime</td>
                                    <td>
                                        <a href=\"$uploads_dir/$filedownload\" download class='me-2'>Download</a>
                                        <a onclick=\"deleteFile('row_$sn','$file')\" href='#'>Delete</a>
                                    </td>
                                </tr>";
                            $sn = $sn + 1;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteFile(row,fileName) {
            if (confirm("Sure to delete " + fileName + " ?")) {
                fetch('handle_files.php?delete=' + encodeURIComponent(fileName))
                    .then(response => response.text())
                    .then(data => {
                        if (data == "deleted") {
                            document.getElementById(row).remove();
                        }
                    });
            }
        }
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>