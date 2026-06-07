<?php
include 'config.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM campaigns WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);


$dokumentasi = mysqli_query(
    $conn,
    "SELECT * FROM dokumentasi
     WHERE campaign_id='$id'"
);

$lainnya = mysqli_query(
    $conn,
    "SELECT * FROM campaigns
     WHERE id != '$id'
     LIMIT 4"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Campaign</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<header>
    <h1>Detail Campaign</h1>
</header>

<main class="container">

    <a href="home.php" class="btn-back">← Kembali</a>

    <section class="detail-card">

        <div class="detail-left">

            <h2>
                <?php echo $data['title']; ?>
            </h2>

          <img 
            src="<?php echo $data['image']; ?>" 
            class="main-img-detail"
        >

        </div>

        <div class="detail-right">

            <div class="docs-box">

               <h3>Dokumentasi</h3>

               <div class="gallery-grid">

               <?php while($foto = mysqli_fetch_assoc($dokumentasi)) { ?>

                    <img src="<?php echo $foto['image']; ?>">

                <?php } ?>

                </div>

            </div>

            <div class="info-box">

                <h2>Detail Kampanye Donasi</h2>

                <div class="meta-list">

                    <p>
                        <strong>Lokasi:</strong>
                        <?php echo $data['location']; ?>
                    </p>

                    <p>
                        <strong>Deskripsi:</strong>
                        <?php echo $data['description']; ?>
                    </p>

                </div>

                <div class="funds-info">

                    <p>
                        <strong>Target:</strong>
                        Rp <?php echo number_format($data['target_amount']); ?>
                    </p>

                    <p>
                        <strong>Terkumpul:</strong>
                        Rp <?php echo number_format($data['collected_amount']); ?>
                    </p>

                </div>

                <div class="progress-container">
                    <div class="progress-bar" style="width: 40%;"></div>
                </div>

                <small>
                    Deadline:
                    <?php echo $data['deadline']; ?>
                </small>

                <div class="donation-methods">

                    <h3>Metode Donasi</h3>

                    <ul>
                        <li>Bank BCA - 123456789</li>
                        <li>OVO / DANA / GoPay</li>
                    </ul>

                </div>

                <div class="action-buttons">

                    <a href="home.php" class="link-back">
                        Kembali
                    </a>

                    <a 
                        href="donasi.php?id=<?php echo $data['id']; ?>" 
                        class="btn-donate"
                    >
                        Donasi Sekarang
                    </a>

                </div>

            </div>

        </div>

    </section>

    <h3 class="section-title">Campaign Lainnya</h3>

  <div class="recommendation-scroll">

<?php while($row = mysqli_fetch_assoc($lainnya)) { ?>

    <div class="rec-item">

        <img src="<?php echo $row['image']; ?>">

        <p>
            <?php echo $row['title']; ?>
        </p>

    </div>

<?php } ?>

</div>
</main>

<footer>
    <p>© 2026 Crowdfunding Sosial</p>
</footer>

</body>
</html>