<?php
session_start();
require 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../pages/tela_inicial.html");
    exit;
}

$receita_id = intval($_GET['id']);

try {
    // Buscar receita com informações do autor
    $sql = "SELECT r.*, u.nome as autor_nome, u.email as autor_email
            FROM receitas r 
            INNER JOIN usuarios u ON r.usuario_id = u.id 
            WHERE r.id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $receita_id]);
    $receita = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$receita) {
        header("Location: ../pages/tela_inicial.html?erro=receita_nao_encontrada");
        exit;
    }
    
    // Verificar se está nos favoritos (se usuário logado)
    $isFavorito = false;
    if (isset($_SESSION['user_id'])) {
        $favSql = "SELECT 1 FROM favoritos WHERE usuario_id = :user_id AND receita_id = :receita_id";
        $favStmt = $pdo->prepare($favSql);
        $favStmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':receita_id' => $receita_id
        ]);
        $isFavorito = $favStmt->fetch() !== false;
    }
    
    // Buscar receitas relacionadas (mesma categoria, exceto a atual)
    $relatedSql = "SELECT r.id, r.nome, r.descricao, r.tempo_preparo_minutos, u.nome as autor_nome
                   FROM receitas r 
                   INNER JOIN usuarios u ON r.usuario_id = u.id 
                   WHERE r.categoria = :categoria AND r.id != :id 
                   ORDER BY r.data_postagem DESC 
                   LIMIT 4";
    
    $relatedStmt = $pdo->prepare($relatedSql);
    $relatedStmt->execute([
        ':categoria' => $receita['categoria'],
        ':id' => $receita_id
    ]);
    $receitasRelacionadas = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Retornar como JSON se solicitado via AJAX
    if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
        header('Content-Type: application/json');
        echo json_encode([
            'receita' => $receita,
            'is_favorito' => $isFavorito,
            'receitas_relacionadas' => $receitasRelacionadas,
            'is_owner' => isset($_SESSION['user_id']) && $_SESSION['user_id'] == $receita['usuario_id']
        ]);
        exit;
    }
    
} catch (PDOException $e) {
    if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro ao carregar receita']);
        exit;
    }
    header("Location: ../pages/tela_inicial.html?erro=sistema");
    exit;
}
?>