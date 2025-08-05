<?php
session_start();
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$file_path = './product/bag.json';
$existing_data = [];

if(file_exists($file_path)){
    $json_content = file_get_contents($file_path);
    if(!empty($json_content)){
        $existing_data = json_decode($json_content, true);
        
        if(!is_array($existing_data)){
            $existing_data = [];
        }
    }
}

$existing_data[] = $data;
file_put_contents($file_path, json_encode($existing_data, JSON_PRETTY_PRINT));
echo json_encode(['status' => 'success']);

$_SESSION['bag_count'] = count($existing_data);

exit;
?>