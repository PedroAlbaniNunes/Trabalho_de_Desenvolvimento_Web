<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/adicionar_receita.html?erro=nao_logado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $usuario_id = $_SESSION['user_id'];
    
    // Dados do formulário
    $titulo = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_preparo = intval($_POST['tempo'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');
    $dificuldade_raw = trim($_POST['dificuldade'] ?? '');
    $ingredientes = trim($_POST['ingredientes'] ?? '');
    $preparo = trim($_POST['preparo'] ?? '');

    // Mapeamento de dificuldade
    $difficulty_map = [
        '1' => 'Fácil', '2' => 'Médio', '3' => 'Difícil', '4' => 'Chef', '5' => 'Chef'
    ];
    $dificuldade = $difficulty_map[$dificuldade_raw] ?? $dificuldade_raw;
    
    // Validação básica dos textos
    if (empty($titulo) || empty($descricao) || empty($categoria) || empty($dificuldade) || empty($ingredientes) || empty($preparo)) {
        header("Location: ../pages/adicionar_receita.html?erro=campos_obrigatorios");
        exit;
    }
    
    $path_imagem = null; 

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $arquivo = $_FILES['foto'];
        
        // 1. Validar extensão
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($extensao, $permitidos)) {
            header("Location: ../pages/adicionar_receita.html?erro=formato_invalido");
            exit;
        }

        $novo_nome = uniqid() . "." . $extensao;
        
        $diretorio = "../uploads/"; 
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        if (move_uploaded_file($arquivo['tmp_name'], $diretorio . $novo_nome)) {
            $path_imagem = "uploads/" . $novo_nome; 
        } else {
            header("Location: ../pages/adicionar_receita.html?erro=falha_upload");
            exit;
        }
    }
    // ----------------------------------

    try {
        $sql = "INSERT INTO receitas (
                    usuario_id, nome, descricao, tempo_preparo_minutos, 
                    categoria, dificuldade, ingredientes, modo_preparo, imagem
                ) VALUES (
                    :usuario_id, :nome, :descricao, :tempo_preparo, 
                    :categoria, :dificuldade, :ingredientes, :preparo, :imagem
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
            ':preparo'      => $preparo,
            ':imagem'       => $path_imagem 
        ]);

        header("Location: ../pages/adicionar_receita.html?sucesso=true");
        exit;

    } catch (PDOException $e) {
        error_log('Recipe creation error: ' . $e->getMessage());
        header("Location: ../pages/adicionar_receita.html?erro=sistema");
        exit;
    }
} else {
    header("Location: ../pages/adicionar_receita.html");
    exit;
}
?>