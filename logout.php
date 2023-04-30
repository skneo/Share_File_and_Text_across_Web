<?php
session_start();
session_destroy();
setcookie("qiurypsfgalvcbnz", "0", time() - 3600);
$new_dir_name = substr(hash('sha256', random_bytes(16)), 0, 32);
include 'uploads_dir.php';
$old_dir_name = $uploads_dir;
rename($old_dir_name, "uploads-$new_dir_name");
file_put_contents("uploads_dir.php", "<?php\n$" . "uploads_dir='uploads-$new_dir_name';");
header('Location: index.php');
