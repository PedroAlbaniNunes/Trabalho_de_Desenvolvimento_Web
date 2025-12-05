<?php
session_start();
require 'conexao.php';

// Parâmetros de paginação e filtros
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 12; // Receitas por página
$offset = ($page - 1) * $limit;

$categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

try {
    // Construir query base
    $whereConditions = [];
    $params = [];
    
    if (!empty($categoria)) {
        $whereConditions[] = "r.categoria = :categoria";
        $params[':categoria'] = $categoria;
    }
    
    if (!empty($busca)) {
        $whereConditions[] = "(r.nome LIKE :busca OR r.descricao LIKE :busca OR r.ingredientes LIKE :busca)";
        $params[':busca'] = "%$busca%";
    }
    
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // Query para contar total de receitas
    $countSql = "SELECT COUNT(*) as total FROM receitas r 
                 INNER JOIN usuarios u ON r.usuario_id = u.id 
                 $whereClause";
    
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $totalReceitas = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Query para buscar receitas com paginação
    $sql = "SELECT r.*, u.nome as autor_nome 
            FROM receitas r 
            INNER JOIN usuarios u ON r.usuario_id = u.id 
            $whereClause 
            ORDER BY r.data_postagem DESC 
            LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($sql);
    
    // Bind search/filter parameters first
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    // Bind pagination parameters as integers
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calcular informações de paginação
    $totalPages = ceil($totalReceitas / $limit);
    
    // Retornar dados como JSON se solicitado via AJAX
    if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
        header('Content-Type: application/json');
        echo json_encode([
            'receitas' => $receitas,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalReceitas,
                'has_next' => $page < $totalPages,
                'has_prev' => $page > 1
            ]
        ]);
        exit;
    }
    
    // Se não for AJAX, incluir na página
    
} catch (PDOException $e) {
    if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro ao carregar receitas']);
        exit;
    }
    $receitas = [];
    $totalPages = 0;
}
?>