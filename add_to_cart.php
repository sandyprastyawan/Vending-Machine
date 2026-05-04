<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $quantity = max(1, (int)$_POST['quantity']);
    $newName  = $_POST['name'];
    $newSize  = $_POST['size'];

    $found = false;

    // Cek apakah item dengan nama & ukuran yang sama sudah ada di keranjang
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $newName && $item['size'] === $newSize) {
                $item['quantity'] += $quantity; // Tambah quantity saja, tidak duplikat
                $found = true;
                break;
            }
        }
        unset($item); // Putus referensi setelah foreach
    }

    // Jika belum ada, tambahkan sebagai item baru
    if (!$found) {
        $_SESSION['cart'][] = [
            'name'     => $newName,
            'size'     => $newSize,
            'price'    => (int)$_POST['price'],
            'image'    => $_POST['image'],
            'quantity' => $quantity
        ];
    }

    header("Location: menu.php");
    exit();
}
