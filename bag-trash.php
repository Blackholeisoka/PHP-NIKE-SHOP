<?php
session_start();
header('Content-type: application/json');

$bag_input = file_get_contents('./product/bag.json');
$bag_data = json_decode($bag_input, true);

$trash_input = file_get_contents('php://input');
$id_to_delete = json_decode($trash_input, true);

if (is_int($id_to_delete) && isset($bag_data[$id_to_delete])) {
    unset($bag_data[$id_to_delete]);

    $bag_data = array_values($bag_data);
    file_put_contents('./product/bag.json', json_encode($bag_data, JSON_PRETTY_PRINT));

    if (count($bag_data) > 0) {
        $_SESSION['bag_count'] = count($bag_data);
    } else {
        unset($_SESSION['bag_count']);
    }

    echo json_encode(['status' => 'success', 'bag_count' => $_SESSION['bag_count'] ?? 0]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Index invalide']);
}
exit;
?>