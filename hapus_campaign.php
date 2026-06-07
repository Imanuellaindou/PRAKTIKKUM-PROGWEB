<?php

include 'config.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user'])){
    header("Location: loginn.php");
    exit;
}

if($_SESSION['user']['role'] != 'penyelenggara'){
    header("Location: home.php");
    exit;
}

$id = $_GET['id'];

$cek = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM donations WHERE campaign_id='$id'"
);

$data = mysqli_fetch_assoc($cek);

if($data && $data['total'] > 0){

    echo "<script>
        alert('Campaign yang sudah memiliki donasi tidak dapat dihapus!');
        window.location='dashboard.php';
    </script>";
    exit;
}

$delete = mysqli_query($conn,
    "DELETE FROM campaigns WHERE id='$id'"
);

if($delete){
    echo "<script>
        alert('Campaign berhasil dihapus!');
        window.location='dashboard.php';
    </script>";
} else {
    echo "Gagal hapus: " . mysqli_error($conn);
}

exit;
?>