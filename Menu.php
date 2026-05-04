<?php
session_start();

// Hitung total item & total harga untuk ditampilkan di badge
$totalItems = 0;
$totalHarga = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $qty = isset($item['quantity']) ? $item['quantity'] : 1;
        $totalItems += $qty;
        $totalHarga += $item['price'] * $qty;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product</title>
  <link rel="stylesheet" href="menu.css">
  <style>
    /* === Cart Badge (gabungan dengan tombol Next) === */
    .cart-badge {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 100;
      text-decoration: none;
    }

    .cart-badge-inner {
      background: white;
      border-radius: 16px;
      padding: 12px 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      display: flex;
      align-items: center;
      gap: 12px;
      transition: 0.3s;
      cursor: pointer;
    }

    .cart-badge-inner:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    /* Jika keranjang kosong, badge tidak bisa diklik */
    .cart-badge.disabled .cart-badge-inner {
      opacity: 0.5;
      cursor: not-allowed;
      pointer-events: none;
    }

    .cart-badge-inner .icon {
      font-size: 1.3rem;
    }

    .cart-badge-info {
      display: flex;
      flex-direction: column;
      line-height: 1.3;
    }

    .cart-badge-info .label {
      font-size: 0.7rem;
      color: #999;
      font-weight: 600;
      font-family: 'Poppins', sans-serif;
    }

    .cart-badge-info .total-price {
      font-size: 0.95rem;
      font-weight: 800;
      color: #111;
      font-family: 'Poppins', sans-serif;
    }

    .cart-count-bubble {
      background: #0015890;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      font-weight: 800;
      font-family: 'Poppins', sans-serif;
      flex-shrink: 0;
    }

    .cart-arrow {
      font-size: 1rem;
      color: #aaa;
    }

    /* === Quantity Control === */
    .quantity-control {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin: 12px 0;
    }

    .qty-btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 2px solid #00578E;
      background: white;
      font-size: 1.2rem;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.2s;
      line-height: 1;
      font-family: 'Poppins', sans-serif;
    }

    .qty-btn:hover {
      background: #00578E;
    }

    .qty-input {
      width: 50px;
      text-align: center;
      font-size: 1rem;
      font-weight: bold;
      border: 2px solid #eee;
      border-radius: 8px;
      padding: 4px;
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body>

<!-- Cart Badge sekaligus tombol ke Checkout -->
<?php if ($totalItems > 0): ?>
  <a href="checkout.php" class="cart-badge">
<?php else: ?>
  <div class="cart-badge disabled">
<?php endif; ?>

    <div class="cart-badge-inner">
      <span class="icon">🛒</span>
      <div class="cart-badge-info">
        <span class="label">
          <?php echo $totalItems > 0 ? "$totalItems item · Lihat Keranjang" : "Keranjang Kosong"; ?>
        </span>
        <span class="total-price">
          <?php echo $totalItems > 0 ? "Rp" . number_format($totalHarga, 0, ',', '.') : "—"; ?>
        </span>
      </div>
      <?php if ($totalItems > 0): ?>
        <div class="cart-count-bubble"><?php echo $totalItems; ?></div>
        <span class="cart-arrow">›</span>
      <?php endif; ?>
    </div>

<?php if ($totalItems > 0): ?>
  </a>
<?php else: ?>
  </div>
<?php endif; ?>


<div class="product-container">

  <!-- Produk 1 -->
  <div class="product-card">
    <h3>SOFTEX <br> DAUN SIRIH</h3>
    <p class="subtitle">29 cm</p>
    <div class="price">Rp25.000</div>
    <div class="image-wrapper">
      <img src="Produk2.png" alt="produk">
    </div>
    <form action="add_to_cart.php" method="POST">
      <input type="hidden" name="name"  value="SOFTEX DAUN SIRIH">
      <input type="hidden" name="size"  value="29 cm">
      <input type="hidden" name="price" value="25000">
      <input type="hidden" name="image" value="Produk2.png">
      <div class="quantity-control">
        <button type="button" class="qty-btn" onclick="changeQty(this, -1)">−</button>
        <input type="number" name="quantity" value="1" min="1" max="10" class="qty-input">
        <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
      </div>
      <button type="submit" name="add_to_cart" class="btn-buy">Tambah ke Keranjang</button>
    </form>
  </div>

  <!-- Produk 2 -->
  <div class="product-card">
    <h3>SOFTEX <br> DAUN SIRIH</h3>
    <p class="subtitle">35 cm</p>
    <div class="price">Rp40.000</div>
    <div class="image-wrapper">
      <img src="Produk1.png" alt="produk">
    </div>
    <form action="add_to_cart.php" method="POST">
      <input type="hidden" name="name"  value="SOFTEX DAUN SIRIH">
      <input type="hidden" name="size"  value="35 cm">
      <input type="hidden" name="price" value="40000">
      <input type="hidden" name="image" value="Produk1.png">
      <div class="quantity-control">
        <button type="button" class="qty-btn" onclick="changeQty(this, -1)">−</button>
        <input type="number" name="quantity" value="1" min="1" max="10" class="qty-input">
        <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
      </div>
      <button type="submit" name="add_to_cart" class="btn-buy">Tambah ke Keranjang</button>
    </form>
  </div>

</div>

<div id="transition-overlay" class="active"></div>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('transition-overlay');
    setTimeout(() => overlay.classList.remove('active'), 100);
  });

  function changeQty(btn, delta) {
    const input = btn.closest('.quantity-control').querySelector('.qty-input');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 10) val = 10;
    input.value = val;
  }
</script>

</body>
</html>
