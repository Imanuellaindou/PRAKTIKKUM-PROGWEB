<?php
include 'config.php';

session_start();

$cari = "";

if(isset($_GET['cari'])){

    $cari = $_GET['cari'];

    $query = mysqli_query(
        $conn,
        "SELECT *
         FROM campaigns
         WHERE title LIKE '%$cari%'"
    );

}else{

    $query = mysqli_query(
        $conn,
        "SELECT *
         FROM campaigns"
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Crowdfunding Sosial</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<header>

  <div class="header-left">
      <h1>Crowdfunding Sosial</h1>
      <p class="subtitle">
          Bersama bantu sesama dengan mudah dan transparan
      </p>
  </div>

  <nav>

      <?php if(isset($_SESSION['user'])) { ?>

          <span>
              Halo,
              <?php echo $_SESSION['user']['name']; ?>
          </span>

         <a href="riwayat_donasi.php">
             Riwayat Donasi
         </a>

        |
          <a href="logout.php">
              Logout
          </a>

      <?php } else { ?>

          <a href="loginn.php">
              Login
          </a>

      <?php } ?>

  </nav>

</header>

<form method="GET" class="search-box">

    <input
        type="text"
        name="cari"
        placeholder="Cari Kampanye..."
        value="<?php echo $cari; ?>"
    >

    <button type="submit">
        Cari
    </button>

</form>

</div>

<h2 class="title">Kampanye Donasi Terbaru</h2>
<?php

if(isset($_GET['cari'])){

    echo "<p>Hasil pencarian untuk: <b>$cari</b></p>";
}
?>

<section class="campaign-list">

<?php while($data = mysqli_fetch_assoc($query)) { ?>

  <div class="card">

    <img 
  src="<?php echo $data['image']; ?>" 
  alt="gambar campaign"
>

    <div class="card-content">

      <h3>
        <?php echo $data['title']; ?>
      </h3>

      <p>
        Lokasi:
        <?php echo $data['location']; ?>
      </p>

      <p>
        Target Dana:
        Rp <?php echo number_format($data['target_amount']); ?>
      </p>

    </div>

    <div class="card-bottom">

      <div class="progress">

        <?php
        $progress = ($data['collected_amount'] / $data['target_amount']) * 100;
        ?>

        <div 
          class="progress-bar"
          style="width: <?php echo $progress; ?>%;"
        ></div>

      </div>

      <small>
        Dana terkumpul:
        Rp <?php echo number_format($data['collected_amount']); ?>
      </small>

      <a href="detail.php?id=<?php echo $data['id']; ?>" class="btn">
        Lihat Detail
      </a>

    </div>

  </div>

<?php } ?>

</section>

<footer>
    <p>© 2026 Crowdfunding Sosial</p>
</footer>

</body>
</html>