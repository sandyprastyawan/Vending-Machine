<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Sanitary On The Go</title>
    <link rel="stylesheet" href="checkout.css">
    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #888;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #333;
            background: rgba(0,0,0,0.05);
        }

        /* Item layout */
        .cart-item {
            position: relative;
        }

        /* Quantity control */
        .item-qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
        }

        .item-qty-btn {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1.5px solid #ddd;
            background: white;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            line-height: 1;
            font-family: 'Inter', sans-serif;
        }

        .item-qty-btn:hover {
            border-color: #00578E;
            background: #00578E;
        }

        .item-qty-display {
            font-size: 0.9rem;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
        }

        .item-subtotal {
            font-size: 0.75rem;
            color: #aaa;
            margin-top: 2px;
        }

        /* Tombol hapus */
        .delete-btn {
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #ccc;
            padding: 6px;
            border-radius: 8px;
            transition: 0.2s;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-btn:hover {
            color: #ff4d4d;
            background: rgba(255, 77, 77, 0.08);
        }

        /* Geser harga ke kiri agar tidak bertabrakan dengan tombol hapus */
        .item-price {
            margin-right: 36px;
        }

        /* Animasi saat item dihapus */
        .cart-item.removing {
            animation: fadeOutItem 0.3s ease forwards;
        }

        @keyframes fadeOutItem {
            from { opacity: 1; transform: translateX(0); max-height: 100px; }
            to   { opacity: 0; transform: translateX(30px); max-height: 0; padding: 0; overflow: hidden; }
        }

        .summary-row.total {
            background: #fafff0;
            padding: 10px 12px;
            border-radius: 10px;
        }

        /* Pesan keranjang kosong */
        .empty-cart-msg {
            text-align: center;
            color: #aaa;
            padding: 2rem 1rem;
            font-size: 0.95rem;
        }

        .empty-cart-msg span {
            display: block;
            font-size: 2.5rem;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="cart-container">

        <a href="menu.php" class="back-link">← Kembali ke Menu</a>

        <h2 class="cart-title">🛒 Keranjang</h2>

        <div class="cart-items" id="cart-items-wrapper">
        <?php 
        $subtotal    = 0;
        $total_items = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): 
            foreach ($_SESSION['cart'] as $index => $item):
                $qty        = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                $item_total = $item['price'] * $qty;
                $subtotal  += $item_total;
                $total_items += $qty;
        ?>
            <div class="cart-item" id="cart-item-<?php echo $index; ?>">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" class="item-img">

                <div class="item-details">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p><?php echo htmlspecialchars($item['size']); ?></p>

                    <!-- Quantity control -->
                    <div class="item-qty-control">
                        <button class="item-qty-btn"
                            onclick="updateQty(<?php echo $index; ?>, -1, <?php echo $item['price']; ?>)">−</button>
                        <span class="item-qty-display" id="qty-<?php echo $index; ?>"><?php echo $qty; ?></span>
                        <button class="item-qty-btn"
                            onclick="updateQty(<?php echo $index; ?>, 1, <?php echo $item['price']; ?>)">+</button>
                    </div>

                    <p class="item-subtotal" id="sub-label-<?php echo $index; ?>">
                        Rp<?php echo number_format($item['price'], 0, ',', '.'); ?> × <?php echo $qty; ?>
                    </p>
                </div>

                <div class="item-price" id="price-<?php echo $index; ?>">
                    Rp<?php echo number_format($item_total, 0, ',', '.'); ?>
                </div>

                <!-- Tombol Hapus -->
                <button class="delete-btn" title="Hapus item"
                    onclick="removeItem(<?php echo $index; ?>, '<?php echo urlencode($item['name']); ?>')">
                    🗑️
                </button>
            </div>
        <?php 
            endforeach; 
        else: ?>
            <div class="empty-cart-msg" id="empty-msg">
                <span>🛒</span>
                Keranjang kamu kosong.<br>
                <a href="menu.php" style="color:#00578E;font-weight:700;text-decoration:none;">Kembali ke Menu →</a>
            </div>
        <?php endif; ?>
        </div>

        <!-- Ringkasan Harga -->
        <div class="summary-section" id="summary-section">
            <div class="summary-row">
                <span>Total Item</span>
                <span id="summary-total-items"><?php echo $total_items; ?> item</span>
            </div>
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="summary-subtotal">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
            </div>
            <div class="summary-row">
                <span>Pajak</span>
                <span>Rp0</span>
            </div>
            <hr class="divider">
            <div class="summary-row total">
                <span>Total</span>
                <span id="summary-total">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="action-wrapper" id="action-wrapper">
            <button class="primary-btn">Checkout</button>
            <a href="cancel_order.php" class="cancel-link">Batalkan Semua Pesanan</a>
        </div>

    </div>

<script>
    // Data cart dari PHP
    let cartData = <?php
        $jsCart = [];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $i => $item) {
                $jsCart[] = [
                    'index'    => $i,
                    'price'    => $item['price'],
                    'quantity' => isset($item['quantity']) ? (int)$item['quantity'] : 1,
                    'active'   => true
                ];
            }
        }
        echo json_encode($jsCart);
    ?>;

    function formatRupiah(num) {
        return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function recalcSummary() {
        let totalItems = 0;
        let subtotal   = 0;
        cartData.forEach(i => {
            if (i.active) {
                totalItems += i.quantity;
                subtotal   += i.price * i.quantity;
            }
        });
        document.getElementById('summary-total-items').textContent = totalItems + ' item';
        document.getElementById('summary-subtotal').textContent    = formatRupiah(subtotal);
        document.getElementById('summary-total').textContent       = formatRupiah(subtotal);
    }

    function updateQty(index, delta, price) {
        const item    = cartData.find(i => i.index === index);
        const newQty  = Math.max(1, item.quantity + delta);
        item.quantity = newQty;

        document.getElementById('qty-' + index).textContent       = newQty;
        document.getElementById('price-' + index).textContent     = formatRupiah(price * newQty);
        document.getElementById('sub-label-' + index).textContent = formatRupiah(price) + ' × ' + newQty;

        recalcSummary();
    }

    function removeItem(index, name) {
        const row  = document.getElementById('cart-item-' + index);
        const item = cartData.find(i => i.index === index);

        // Animasi hilang dulu, baru redirect ke remove_item.php
        row.classList.add('removing');
        item.active = false;
        recalcSummary();

        setTimeout(() => {
            row.remove();

            // Cek apakah semua item sudah dihapus
            const remaining = document.querySelectorAll('.cart-item');
            if (remaining.length === 0) {
                document.getElementById('cart-items-wrapper').innerHTML =
                    `<div class="empty-cart-msg">
                        <span>🛒</span>
                        Keranjang kamu kosong.<br>
                        <a href="menu.php" style="color:#00578E;font-weight:700;text-decoration:none;">Kembali ke Menu →</a>
                    </div>`;
                document.getElementById('summary-section').style.display  = 'none';
                document.getElementById('action-wrapper').style.display   = 'none';
            }

            // Sync ke session PHP via redirect tersembunyi
            window.location.href = 'remove_item.php?index=' + index;
        }, 300);
    }
</script>

</body>
</html>
