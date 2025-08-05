<?php
session_start();
header('Content-type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$id = $input['id'] ?? null;
$quantity = $input['count'] ?? null;

if (!is_int($id) || !is_int($quantity) || $quantity < 1 || $quantity > 10) {
    echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
    exit;
}

$bag_data = json_decode(file_get_contents('./product/bag.json'), true);

if (!isset($bag_data[$id])) {
    echo json_encode(['status' => 'error', 'message' => 'Article introuvable']);
    exit;
}

$bag_data[$id]['quantity'] = $quantity;
file_put_contents('./product/bag.json', json_encode($bag_data, JSON_PRETTY_PRINT));

echo json_encode(['status' => 'success']);
exit;
?>