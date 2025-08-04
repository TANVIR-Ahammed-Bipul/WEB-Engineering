<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check for direct single product order
if (isset($_POST['direct_product_id'])) {
    $productId = (int) $_POST['direct_product_id'];
    $quantity = isset($_POST['direct_quantity']) ? max(1, (int) $_POST['direct_quantity']) : 1;

    if ($productId > 0) {
        // Override cart with one item for direct order
        $_SESSION['cart'] = [$productId => $quantity];
    } else {
        header("Location: index.php?toast=Invalid product selection");
        exit();
    }
}

// Validate cart before placing order
if (empty($_SESSION['cart'])) {
    header("Location: index.php?toast=Cart is empty");
    exit();
}

try {
    $pdo->beginTransaction();

    $productIds = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate total
    $total = 0;
    foreach ($products as $product) {
        $pid = $product['id'];
        $price = $product['price'];
        $qty = $_SESSION['cart'][$pid] ?? 0;
        $total += $price * $qty;
    }

    // Insert into orders table
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $total]);
    $orderId = $pdo->lastInsertId();

    // Insert into order_items table
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($products as $product) {
        $pid = $product['id'];
        $stmt->execute([
            $orderId,
            $pid,
            $_SESSION['cart'][$pid],
            $product['price']
        ]);
    }

    $pdo->commit();
    unset($_SESSION['cart']);
    header("Location: index.php?toast=Order placed successfully");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    header("Location: index.php?toast=Order failed. Please try again.");
    exit();
}
