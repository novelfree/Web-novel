<?php
session_start();

// Periksa apakah pengguna adalah admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Access denied. Only admins can upload novels.");
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Cek apakah file gambar adalah gambar asli atau palsu
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Cek apakah file sudah ada
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Batasi ukuran file
if ($_FILES["image"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Batasi format file
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Cek apakah $uploadOk 0 karena ada kesalahan
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// jika semuanya baik-baik saja, coba upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        // Simpan detail novel ke file atau database
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $synopsis = $_POST['synopsis'];
        $image = $target_file;

        // Simpan ke file JSON
        $novel = [
            'title' => $title,
            'author' => $author,
            'genre' => $genre,
            'synopsis' => $synopsis,
            'image' => $image,
        ];
        $novels = json_decode(file_get_contents('novels.json'), true);
        $novels[] = $novel;
        file_put_contents('novels.json', json_encode($novels));
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
