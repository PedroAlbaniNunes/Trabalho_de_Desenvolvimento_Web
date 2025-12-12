<?php
session_start();

header('Content-Type: application/json');

// Verifica user_id (que é como você salvou no login.php)
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    echo json_encode([
        'logado' => true,
        'nome' => $_SESSION['user_nome'] ?? 'Usuário'
    ]);
} else {
    echo json_encode(['logado' => false]);
}
?>