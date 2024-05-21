<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";  // Sesuaikan dengan username MySQL Anda
$password = "";  // Sesuaikan dengan password MySQL Anda, jika ada
$dbname = "gallery_comment";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi variabel untuk pesan notifikasi
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // Validasi data dari form
    if (!empty($name) && !empty($comment)) {
        $name = htmlspecialchars($name);  // Mencegah XSS
        $comment = htmlspecialchars($comment);

        // Menyiapkan dan menyisipkan pernyataan SQL menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $name, $comment);

        // Menjalankan pernyataan
        if ($stmt->execute() === TRUE) {
            $message = "Komentar berhasil disimpan!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        // Menutup pernyataan
        $stmt->close();
    } else {
        $message = "Nama dan komentar harus diisi.";
    }
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Komentar</title>
    <script>
        // Fungsi untuk menutup notifikasi setelah beberapa detik
        function closeNotification() {
            var notification = document.getElementById('notification');
            notification.style.display = 'none';
        }

        // Menutup notifikasi setelah 3 detik
        setTimeout(closeNotification, 3000);
    </script>
    <style>
        /* Gaya untuk notifikasi */
        #notification {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: block;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <!-- Menampilkan pesan notifikasi -->
    <div id="notification"><?php echo $message; ?></div>
    <!-- Tombol untuk kembali ke galeri -->
    <a href="gallery.html">Kembali ke Galeri</a>

    <!-- Script untuk menutup notifikasi setelah beberapa detik -->
    <script>
        // Fungsi untuk menutup notifikasi setelah beberapa detik
        function closeNotification() {
            var notification = document.getElementById('notification');
            notification.style.display = 'none';
        }

        // Menutup notifikasi setelah 3 detik
        setTimeout(closeNotification, 3000);
    </script>
</body>

</html>