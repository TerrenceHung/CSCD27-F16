<?php
session_start();
$email = $_SESSION['user']['email'];

$type = (string)$_POST['optionsimagetype'];

switch ($type) {
    case "url":
        $url = (string)$_POST['url'];
        break;
    case "file":
    // sample code from: http://www.php.net/manual/en/features.file-upload.php
    try {
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (
            !isset($_FILES['upfile']['error']) ||
            is_array($_FILES['upfile']['error'])
        ) {
            throw new RuntimeException('Invalid parameters.');
        }

        // Check $_FILES['upfile']['error'] value.
        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // You should also check filesize here.
        if ($_FILES['upfile']['size'] > 1000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
        // Check MIME Type by yourself.
        // $finfo = new finfo(FILEINFO_MIME_TYPE);
        // if (false === $ext = array_search(
        //     $finfo->file($_FILES['upfile']['tmp_name']),
        //     array(
        //         'jpg' => 'image/jpeg',
        //         'png' => 'image/png',
        //         'gif' => 'image/gif',
        //     ),
        //     true
        // )) {
        //     throw new RuntimeException('Invalid file format.');
        // }

        $name = $_FILES["upfile"]["name"];
        $ext = end(explode(".", $name));

        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        $filename = sha1_file($_FILES['upfile']['tmp_name']);
        if (!move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            sprintf('./media/uploads/%s.%s',
                $filename,
                $ext
            )
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        // echo 'File is uploaded successfully.';
        $url = "/media/uploads/" . $filename . "." . $ext;

    } catch (RuntimeException $e) {
        echo $e->getMessage();
        die();
    }
}

$db = new mysqli("localhost","root","pass4root","microblogging");
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}
$query = "UPDATE profiles SET url='$url' WHERE owner = '$email'";
$res = $db->query($query);
$db->close();
header("location:/");
?>