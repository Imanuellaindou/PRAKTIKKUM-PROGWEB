<?php
include 'config.php';

session_start();

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE email='$email'
        AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['user'] = $data;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['role'] = $data['role'];

        if($data['role'] == 'penyelenggara'){

            header("Location: dashboard.php");
            exit;

        } else {

            header("Location: home.php");
            exit;
        }

    } else {

        echo "
        <script>
            alert('Email atau Password salah!');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<header>
    <h1>Login</h1>
</header>

<section class="form">

    <h2>Masuk ke Akun</h2>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Masukkan Email"
            required
        >

        <br><br>

        <input
            type="password"
            name="password"
            placeholder="Masukkan Password"
            required
        >

        <br><br>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <br>

    <a href="register_donatur.php" class="btn">
        Register Donatur
    </a>

    <br><br>

    <a href="register_penyelenggara.php" class="btn">
        Register Penyelenggara
    </a>

    <br><br>

    <a href="home.php">
        Kembali ke Beranda
    </a>

</section>

<footer>
    <p>© 2026 Crowdfunding Sosial</p>
</footer>

</body>
</html>