<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
$showAlert = false;
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['url'])) {
    $url = validateInput($_POST['url']);
    $tag = validateInput($_POST['tag']);
    date_default_timezone_set('Asia/Kolkata');
    $curr_date = date('Y-m-d H:i:s');

    $all_links = file_get_contents("all_links.json");
    $all_links = json_decode($all_links, true);
    if ($all_links == NULL)
        $all_links = array();

    $link = array();
    array_push($link, $url, $tag, $curr_date);
    $all_links[$curr_date] = $link;
    file_put_contents("all_links.json", json_encode($all_links));

    $showAlert = true;
    $alertClass = "alert-success";
    $alertMsg = "Text saved";
}

if (isset($_GET['delete'])) {
    $url_index = $_GET['delete'];

    $all_links = file_get_contents("all_links.json");
    $all_links = json_decode($all_links, true);

    unset($all_links[$url_index]);
    file_put_contents("all_links.json", json_encode($all_links));

    $showAlert = true;
    $alertClass = "alert-success";
    $alertMsg = "Text deleted";
}
?>

<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="sharelogo.png">
    <title>Share Text</title>
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
    <div class="container my-3 text-center">
        <!-- Modal Button-->
        <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Text
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Text</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method='POST'>
                            <div class='mb-3'>
                                <label for='url' class='form-label float-start'>Text</label>
                                <textarea class='form-control' name="url" cols="20" rows="5"></textarea>
                            </div>
                            <div class='mb-3'>
                                <label for='tag' class='form-label float-start'>Remark</label>
                                <input type='text' class='form-control' name='tag'>
                            </div>
                            <button type='submit' class='btn btn-primary'>Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="mt-3 mx-3 mb-0 text-center">
        <h4><a href="share_text.php"> All Texts </a></h4>
    </div>
    <div style="margin-top: 0px;" class="container">
        <?php
        function url_to_clickable_link($plaintext)
        {
            return preg_replace(
                '%(https?|ftp)://([-A-Z0-9-./_*?&;=#]+)%i',
                '<a target="blank" rel="nofollow" href="$0" target="_blank">$0</a>',
                $plaintext
            );
        }
        $all_links = file_get_contents("all_links.json");
        $all_links = json_decode($all_links, true);
        if ($all_links != NULL)
            $rowNos = count($all_links);
        else $rowNos = 0;
        $link_keys = array_keys($all_links);
        for ($x = 0; $x < $rowNos; $x++) {
            $link_key = $link_keys[$x];
            $row = $all_links[$link_key];
            $url = $row[0];
            $url_desc = url_to_clickable_link($url);
            $tag = $row[1];
            $dateAdded = $row[2];
            echo "<b>$x. $dateAdded:</b> $tag
                  <p id='p$x' style='white-space: pre-wrap;'>$url_desc </p>
                  <button type='button' class='btn btn-sm btn-success' id='$x' onclick=\"copyToClipboard(this.id)\" >Copy</button>
                  <a href=\"scan_qr_code.php?qr_url=$url\" class='btn btn-info btn-sm mx-1'>QR Code</a>
                  <a href='share_text.php?delete=$dateAdded' class='btn btn-danger btn-sm' onclick=\"return confirm('Sure to delete \'$tag\'?')\">Delete</a>
                  <hr>";
        }
        ?>
    </div>
    <script>
        function copyToClipboard(element) {
            const elem = document.createElement('textarea');
            elem.value = $(`#p${element}`).text();
            document.body.appendChild(elem);
            elem.select();
            document.execCommand('copy');
            document.body.removeChild(elem);
            $(`#${element}`).text("Copied");
            setTimeout(() => {
                document.getElementById(element).innerText = 'Copy';
            }, 1000);
        }
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>