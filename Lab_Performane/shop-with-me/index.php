<?php
require_once __DIR__ . '/includes/db.php';
session_start();

// Fetch first 3 products
$stmt = $pdo->query("SELECT * FROM products LIMIT 3");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop With Me</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/shop-with-me/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="nav-left">
            <h1>Shop With Me</h1>
        </div>

        <div class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="account.php">My Account</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>

            <div class="dropdown">
                <button class="dropbtn">Items <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <?php
                    $categories = $pdo->query("SELECT * FROM categories")->fetchAll();
                    foreach ($categories as $category) {
                        echo "<a href='category.php?id={$category['id']}'>{$category['name']}</a>";
                    }
                    ?>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn">Offer <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <a href="#">Family Pack</a>
                    <a href="#">Ifter</a>
                    <a href="#">Offer</a>
                </div>
            </div>

            <div class="search-box">
                <form action="search.php" method="get">
                    <input type="text" name="query" placeholder="Type your item">
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="cart-icon">
                <i class="fa fa-cart-arrow-down">
                    <sub><?= array_sum($_SESSION['cart']) ?></sub>
                </i>
            </div>
        </div>
    </nav>
</header>

<section class="hero-section">
    <button class="hero-btn">Order Now</button>
</section>

<main class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p>
                <?php if ($product['old_price']): ?>
                    <span class="old-price">$<?= number_format($product['old_price'], 2) ?></span>
                <?php endif; ?>
                <span class="new-price">$<?= number_format($product['price'], 2) ?></span>
            </p>
            <div class="product-buttons">
                <!-- Add to Cart -->
                <form action="add_to_cart.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="cart-btn">
                        <i class="fa fa-cart-plus"></i>
                    </button>
                </form>
                
                <!-- Order Now (Direct Purchase) -->
                <form action="place_order.php" method="post" style="display:inline;">
                    <input type="hidden" name="direct_product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="direct_quantity" value="1">
                    <button type="submit" class="view-btn">Order Product</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</main>

<footer>
    <p>&copy; 2025 Shop With Me. All rights reserved.</p>
</footer>
</body>
</html>
