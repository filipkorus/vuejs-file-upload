<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
if (!isset($_FILES['file'])) return;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$upload_folder = './uploads/';

$target_dir = $upload_folder . basename($_FILES['file']['name']);

$file_count = 1;
$new_dir = $target_dir;
while (file_exists($new_dir)) {
   $new_dir = $target_dir;
   $new_dir = substr($new_dir, 0, strrpos($new_dir, '.')) . "($file_count)" . substr($new_dir, strrpos($new_dir, '.'));
   $file_count++;
}

$success = move_uploaded_file($_FILES['file']['tmp_name'], $new_dir);
echo json_encode([
   'success' => $success,
   'filename' => $new_dir
]);
