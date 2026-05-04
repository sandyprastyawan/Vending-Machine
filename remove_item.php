<?php
session_start();

if (isset($_GET['index']) && isset($_SESSION['cart'])) {
    $index = (int)$_GET['index'];

    // Hapus item berdasarkan index, lalu reindex array
    if (array_key_exists($index, $_SESSION['cart'])) {
        array_splice($_SESSION['cart'], $index, 1);
    }
}

header("Location: checkout.php");
exit();
