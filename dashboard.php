<?php

include 'config.php';

session_start();

if(!isset($_SESSION['user'])){

    header("Location: loginn.php");
    exit;
}

if($_SESSION['user']['role'] != 'penyelenggara'){

    header("Location: home.php");
    exit;
}

$id_user = $_SESSION['user']['id'];
$pending = mysqli_query(
    $conn,
    "SELECT SUM(donations.nominal) as total_pending
     FROM donations
     JOIN campaigns
     ON donations.campaign_id = campaigns.id
     WHERE campaigns.organizer_id='$id_user'
     AND donations.status='pending'"
);

$dataPending = mysqli_fetch_assoc($pending);

$query = mysqli_query(
    $conn,
    "SELECT * FROM campaigns
     WHERE organizer_id='$id_user'"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Penyelenggara</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<header>

    <div class="header-left">

        <h1>Dashboard Penyelenggara</h1>

        <p class="subtitle">
            Kelola Campaign dan Verifikasi Donasi
        </p>

    </div>

    <nav>

        Halo,
        <?php echo $_SESSION['user']['name']; ?>

        |

        <a href="tambah_campaign.php">
            Tambah Campaign
        </a>

        |

        <a href="logout.php">
            Logout
        </a>

    </nav>

</header>

<h2 class="title">
    Campaign Saya
</h2>
<div class="pending-box">
    <span class="label">Dana Pending</span>

    <div class="amount">
        Rp <?php echo number_format($dataPending['total_pending'] ?? 0); ?>
    </div>
</div>

<section class="campaign-list">

<?php while($data = mysqli_fetch_assoc($query)){ ?>

<div class="card">

    <img
        src="<?php echo $data['image']; ?>"
        alt="Campaign"
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

        <p>
            Dana Terkumpul:
            Rp <?php echo number_format($data['collected_amount']); ?>
        </p>

    </div>

   <div class="card-bottom">

    <a href="edit_campaign.php?id=<?php echo $data['id']; ?>" class="btn">Edit</a>

    <a href="hapus_campaign.php?id=<?php echo $data['id']; ?>" class="btn">Hapus</a>

    <a href="verifikasi_donasi.php?id=<?php echo $data['id']; ?>" class="btn">Verifikasi</a>

</div>

</div>

<?php } ?>

</section>

<footer>
    <p>© 2026 Crowdfunding Sosial</p>
</footer>

</body>
</html>