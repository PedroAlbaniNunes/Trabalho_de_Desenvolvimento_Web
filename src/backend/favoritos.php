<?php
session_start();
require 'conexao.php';

// Verificar se usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Usuário não logado']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adicionar ou remover favorito
    
    if (!isset($_POST['receita_id']) || !is_numeric($_POST['receita_id'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'ID da receita inválido']);
        exit;
    }
    
    $receita_id = intval($_POST['receita_id']);
    $action = $_POST['action'] ?? 'toggle'; // toggle, add, remove
    
    try {
        // Verificar se receita existe
        $checkSql = "SELECT id FROM receitas WHERE id = :receita_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':receita_id' => $receita_id]);
        
        if (!$checkStmt->fetch()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Receita não encontrada']);
            exit;
        }
        
        // Verificar se já está nos favoritos
        $favSql = "SELECT 1 FROM favoritos WHERE usuario_id = :user_id AND receita_id = :receita_id";
        $favStmt = $pdo->prepare($favSql);
        $favStmt->execute([':user_id' => $user_id, ':receita_id' => $receita_id]);
        $isFavorito = $favStmt->fetch() !== false;
        
        if ($action === 'toggle') {
            if ($isFavorito) {
                // Remover dos favoritos
                $deleteSql = "DELETE FROM favoritos WHERE usuario_id = :user_id AND receita_id = :receita_id";
                $deleteStmt = $pdo->prepare($deleteSql);
                $deleteStmt->execute([':user_id' => $user_id, ':receita_id' => $receita_id]);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'action' => 'removed', 'is_favorito' => false]);
            } else {
                // Adicionar aos favoritos
                $insertSql = "INSERT INTO favoritos (usuario_id, receita_id) VALUES (:user_id, :receita_id)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute([':user_id' => $user_id, ':receita_id' => $receita_id]);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'action' => 'added', 'is_favorito' => true]);
            }
        } elseif ($action === 'add' && !$isFavorito) {
            $insertSql = "INSERT INTO favoritos (usuario_id, receita_id) VALUES (:user_id, :receita_id)";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([':user_id' => $user_id, ':receita_id' => $receita_id]);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'action' => 'added', 'is_favorito' => true]);
        } elseif ($action === 'remove' && $isFavorito) {
            $deleteSql = "DELETE FROM favoritos WHERE usuario_id = :user_id AND receita_id = :receita_id";
            $deleteStmt = $pdo->prepare($deleteSql);
            $deleteStmt->execute([':user_id' => $user_id, ':receita_id' => $receita_id]);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'action' => 'removed', 'is_favorito' => false]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'action' => 'no_change', 'is_favorito' => $isFavorito]);
        }
        
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro no banco de dados']);
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar favoritos do usuário
    
    try {
        $sql = "SELECT r.*, u.nome as autor_nome 
                FROM receitas r 
                INNER JOIN favoritos f ON r.id = f.receita_id 
                INNER JOIN usuarios u ON r.usuario_id = u.id 
                WHERE f.usuario_id = :user_id 
                ORDER BY f.data_favoritado DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode(['favoritos' => $favoritos]);
        
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro ao carregar favoritos']);
    }
}
?>