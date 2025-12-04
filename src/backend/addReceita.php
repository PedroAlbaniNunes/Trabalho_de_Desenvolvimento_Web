<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../..src2/frontend/adicionar_receita.html?erro=nao_logado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $usuario_id = $_SESSION['user_id'];
    
    // Dados do formulário
    $titulo = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $tempo_preparo = $_POST['tempo'];
    $categoria = $_POST['categoria'];
    $dificuldade = $_POST['dificuldade'];
    $ingredientes = $_POST['ingredientes'];
    $preparo = $_POST['preparo']; 

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

        header("Location: ../../src2/frontend/adicionar_receita.html?sucesso=true");
        exit;

    } catch (PDOException $e) {
        header("Location: ../../src2/frontend/adicionar_receita.html?erro=sistema");
        exit;
    }
} else {
    header("Location: ../../src2/frontend/adicionar_receita.html");
    exit;
}
?>