<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'is_logged_in' => isset($_SESSION['user_id']),
    'user_name' => isset($_SESSION['nome']) ? $_SESSION['nome'] : null
]);
?>