<?php
include 'db.php';

if (isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
    header("Location: manage_categories.php");
    exit;
}

if (isset($_POST['delete_category'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_categories.php");
    exit;
}
?>
