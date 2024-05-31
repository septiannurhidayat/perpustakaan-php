<?php
session_start();

include_once("./connect.php");

// Pastikan koneksi ke database berhasil
if ($db === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Cek apakah data email dan password ada dalam POST request
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Simpan data email ke variabel email
    $email = $_POST['email'];
    // Simpan data password di variabel password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah email sudah pernah terdaftar di database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db,$sql);

    // Debugging
    if (!$result) {
        die("Query error: " . mysqli_error($db));
    }

    // Apakah email ada di database
    if (mysqli_num_rows($result) > 0) {
        echo "Email sudah terdaftar.";
    } else {
        // Bikin 1 query sql baru untuk memasukan data
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

        // Debugging
        if (!mysqli_query($db, $sql)) {
            die("Insert error: " . mysqli_error($db));
        }

        // Kalo registrasi berhasil
        echo "Registrasi berhasil. Silakan <a href='login.php'>login</a>.";
    }
}
