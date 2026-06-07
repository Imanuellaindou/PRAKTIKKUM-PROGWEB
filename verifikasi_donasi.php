<?php

include 'config.php';

session_start();

if(!isset($_SESSION['user'])){
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location='loginn.php';
          </script>";
    exit;
}

if($_SESSION['user']['role'] != 'penyelenggara'){
    header("Location: home.php");
    exit;
}

$campaign_id = $_GET['id'];

$query = mysqli_query($conn,
    "SELECT * FROM donations WHERE campaign_id='$campaign_id'"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Donasi</title>
    <link rel="stylesheet" href="Style.css">
</head>

<body>

<header>
    <h1>Verifikasi Donasi</h1>
</header>

<section class="form">

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>Donor</th>
        <th>Nominal</th>
        <th>Metode</th>
        <th>Pesan</th>
        <th>Status</th>
        <th>Bukti</th>
        <th>Aksi</th>
    </tr>

<?php while($data = mysqli_fetch_assoc($query)){ ?>

    <tr>
        <td><?php echo $data['donor_id']; ?></td>

        <td>Rp <?php echo number_format($data['nominal']); ?></td>

        <td><?php echo $data['payment_method']; ?></td>

        <td><?php echo $data['support_message']; ?></td>

        <td><?php echo $data['status']; ?></td>

        <td>
            <button class="btn" onclick="openProof('<?php echo $data['proof']; ?>')">
                Lihat Bukti
            </button>
        </td>

        <td>

            <a href="approve.php?id=<?php echo $data['id']; ?>" class="btn">
                Terima
            </a>

            <a href="reject.php?id=<?php echo $data['id']; ?>" class="btn">
                Tolak
            </a>

        </td>
    </tr>

<?php } ?>

</table>

</section>

<div id="proofModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeProof()">&times;</span>

        <img id="proofImg" src="" alt="Bukti Transfer">
    </div>
</div>

<script>
function openProof(src){
    document.getElementById('proofModal').style.display = 'block';
    document.getElementById('proofImg').src = src;
}

function closeProof(){
    document.getElementById('proofModal').style.display = 'none';
}

window.onclick = function(event){
    let modal = document.getElementById('proofModal');
    if(event.target == modal){
        modal.style.display = 'none';
    }
}
</script>

<footer>
    <p>© 2026 Crowdfunding Sosial</p>
</footer>

</body>
</html>