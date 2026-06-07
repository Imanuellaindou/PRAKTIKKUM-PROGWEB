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

$id = $_GET['id'];
$aksi = $_GET['aksi'];

$donasi = mysqli_query(
    $conn,
    "SELECT * FROM donations
     WHERE id='$id'"
);

$data = mysqli_fetch_assoc($donasi);

$status_lama = $data['status'];

mysqli_query(
    $conn,
    "UPDATE donations
     SET status='$aksi'
     WHERE id='$id'"
);

mysqli_query(
    $conn,
    "INSERT INTO donation_history
    (
        donation_id,
        old_status,
        new_status
    )
    VALUES
    (
        '$id',
        '$status_lama',
        '$aksi'
    )"
);

if($aksi == 'verified' && $status_lama == 'pending'){

    mysqli_query(
        $conn,
        "UPDATE campaigns
         SET collected_amount =
         collected_amount + ".$data['nominal']."
         WHERE id='".$data['campaign_id']."'"
    );
}

echo "<script>
        alert('Status donasi berhasil diperbarui!');
        window.history.back();
      </script>";

exit;

?>