<?php
// Import koneksi database
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Enkripsi kata sandi dengan Vigenere Cipher (Anda harus mengganti ini dengan algoritma enkripsi yang lebih aman)
    $encrypted_password = vigenere_encrypt($password, "selasa");

    // Simpan data pengguna ke dalam database
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$encrypted_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
function vigenere_encrypt($text, $key) {
    $text = strtoupper($text); // Ubah teks ke huruf kapital
    $key = strtoupper($key);   // Ubah kunci ke huruf kapital
    $encrypted_text = '';

    $text_length = strlen($text);
    $key_length = strlen($key);

    for ($i = 0; $i < $text_length; $i++) {
        $text_char = ord($text[$i]);
        $key_char = ord($key[$i % $key_length]);

        if (ctype_alpha($text[$i])) {
            // Enkripsi hanya dilakukan untuk huruf alfabet
            $encrypted_char = chr(((($text_char - 65) + ($key_char - 65)) % 26) + 65);
            $encrypted_text .= $encrypted_char;
        } else {
            // Tidak perlu mengenkripsi karakter selain huruf alfabet
            $encrypted_text .= $text[$i];
        }
    }

    return $encrypted_text;
}

?>
<!-- HTML form untuk registrasi -->

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Pengguna</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Registrasi Pengguna</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Registrasi">
    </form>
</body>
</html>