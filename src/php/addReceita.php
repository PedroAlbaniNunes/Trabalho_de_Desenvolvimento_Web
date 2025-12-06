<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/adicionar_receita.html?erro=nao_logado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $usuario_id = $_SESSION['user_id'];
    
    // Dados do formulário com validação básica
    $titulo = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_preparo = intval($_POST['tempo'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');
    $dificuldade_raw = trim($_POST['dificuldade'] ?? '');
    $ingredientes = trim($_POST['ingredientes'] ?? '');
    $preparo = trim($_POST['preparo'] ?? '');
    
    // Fix difficulty mapping from numeric to text
    $difficulty_map = [
        '1' => 'Fácil',
        '2' => 'Médio', 
        '3' => 'Difícil',
        '4' => 'Chef',
        '5' => 'Chef'
    ];
    
    // Convert numeric difficulty to text if needed
    if (isset($difficulty_map[$dificuldade_raw])) {
        $dificuldade = $difficulty_map[$dificuldade_raw];
    } else {
        $dificuldade = $dificuldade_raw; // Already text format
    }
    
    // Validação básica
    if (empty($titulo) || empty($descricao) || empty($categoria) || empty($dificuldade) || empty($ingredientes) || empty($preparo)) {
        header("Location: ../pages/adicionar_receita.html?erro=campos_obrigatorios");
        exit;
    }
    
    if ($tempo_preparo <= 0) {
        header("Location: ../pages/adicionar_receita.html?erro=tempo_invalido");
        exit;
    } 

    try {
        $sql = "INSERT INTO receitas (
                    usuario_id, nome, descricao, tempo_preparo_minutos, 
                    categoria, dificuldade, ingredientes, modo_preparo
                ) VALUES (
                    :usuario_id, :nome, :descricao, :tempo_preparo, 
                    :categoria, :dificuldade, :ingredientes, :preparo
                )";
        
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id'   => $usuario_id,
            ':nome'         => $titulo,
            ':descricao'    => $descricao,
            ':tempo_preparo'=> $tempo_preparo,
            ':categoria'    => $categoria,
            ':dificuldade'  => $dificuldade,
            ':ingredientes' => $ingredientes,
            ':preparo'      => $preparo
        ]);

        header("Location: ../pages/adicionar_receita.html?sucesso=true");
        exit;

    } catch (PDOException $e) {
        // Log error for debugging
        error_log('Recipe creation error: ' . $e->getMessage());
        header("Location: ../pages/adicionar_receita.html?erro=sistema");
        exit;
    }
} else {
    header("Location: ../pages/adicionar_receita.html");
    exit;
}
?>