<?php
session_start();
require 'conexao.php';

// --- 1. LÓGICA PHP (BACKEND) ---

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../pages/tela_inicial.html");
    exit;
}

$receita_id = intval($_GET['id']);

try {
    // Buscar receita e autor
    $sql = "SELECT r.*, u.nome as autor_nome 
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

    // Verificar Favorito
    $isFavorito = false;
    if (isset($_SESSION['user_id'])) {
        $favSql = "SELECT 1 FROM favoritos WHERE usuario_id = :user_id AND receita_id = :receita_id";
        $favStmt = $pdo->prepare($favSql);
        $favStmt->execute([':user_id' => $_SESSION['user_id'], ':receita_id' => $receita_id]);
        $isFavorito = $favStmt->fetch() !== false;
    }

    // Buscar Receitas Relacionadas (mesma categoria)
    $relatedSql = "SELECT r.id, r.nome, r.descricao, r.tempo_preparo_minutos, r.imagem 
                   FROM receitas r 
                   WHERE r.categoria = :categoria AND r.id != :id 
                   ORDER BY r.data_postagem DESC LIMIT 4";
    $relatedStmt = $pdo->prepare($relatedSql);
    $relatedStmt->execute([':categoria' => $receita['categoria'], ':id' => $receita_id]);
    $relacionadas = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Preparar Imagem Principal
    $imagemUrl = !empty($receita['imagem']) ? "../" . $receita['imagem'] : "https://placehold.co/800x400/e9ecef/4a572c?text=Sem+Foto";

    // Formatar data
    $dataPostagem = date('d/m/Y', strtotime($receita['data_postagem']));

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($receita['nome']); ?> - Brio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
  </head>

  <body class="d-flex flex-column min-vh-100 bg-light">
    
    <div class="container py-4">
      
      <div class="row mb-4">
        <div class="col-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="../pages/tela_inicial.html" class="text-decoration-none text-muted">Início</a></li>
              <li class="breadcrumb-item"><a href="../pages/receitas.html" class="text-decoration-none text-muted">Receitas</a></li>
              <li class="breadcrumb-item active text-brio-green fw-bold" aria-current="page"><?php echo htmlspecialchars($receita['nome']); ?></li>
            </ol>
          </nav>

          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h1 class="text-brio-green mb-2 playfair display-5"><?php echo htmlspecialchars($receita['nome']); ?></h1>
              <p class="text-muted mb-0">
                Por: <span class="fw-bold"><?php echo htmlspecialchars($receita['autor_nome']); ?></span>
              </p>
              <small class="text-muted">Publicado em <?php echo $dataPostagem; ?></small>
            </div>
            
            <div>
                <button id="btn-favorito" class="btn <?php echo $isFavorito ? 'btn-danger' : 'btn-outline-danger'; ?>" onclick="toggleFavorito(<?php echo $receita['id']; ?>, this)">
                    <i class="<?php echo $isFavorito ? 'fas' : 'far'; ?> fa-heart"></i> 
                    <span id="txt-favorito"><?php echo $isFavorito ? 'Favoritado' : 'Favoritar'; ?></span>
                </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
          <div class="col-12">
              <div class="rounded-4 overflow-hidden shadow-sm" style="max-height: 400px;">
                  <img src="<?php echo $imagemUrl; ?>" class="w-100" style="height: 400px; object-fit: cover;" alt="<?php echo htmlspecialchars($receita['nome']); ?>">
              </div>
          </div>
      </div>

      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <h5 class="card-title text-brio-green mb-3">Sobre a Receita</h5>
              <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($receita['descricao'])); ?></p>

              <hr class="my-4">

              <div class="row text-center">
                <div class="col-4 border-end">
                  <h6 class="text-muted mb-1"><i class="fas fa-clock text-warning me-1"></i> Tempo</h6>
                  <span class="fw-bold"><?php echo $receita['tempo_preparo_minutos']; ?> min</span>
                </div>
                <div class="col-4 border-end">
                  <h6 class="text-muted mb-1"><i class="fas fa-signal text-info me-1"></i> Dificuldade</h6>
                  <span class="fw-bold"><?php echo htmlspecialchars($receita['dificuldade']); ?></span>
                </div>
                <div class="col-4">
                  <h6 class="text-muted mb-1"><i class="fas fa-utensils text-success me-1"></i> Categoria</h6>
                  <span class="fw-bold"><?php echo htmlspecialchars($receita['categoria']); ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
              <h5 class="card-title text-brio-green mb-3">Ações Rápidas</h5>
              <div class="d-grid gap-2">
                <button class="btn btn-outline-primary" onclick="window.print()">
                  <i class="fas fa-print"></i> Imprimir
                </button>
                <button class="btn btn-outline-success" onclick="compartilharReceita()">
                  <i class="fas fa-share-alt"></i> Compartilhar
                </button>
                <a href="../pages/receitas.html" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Voltar
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-5">
        <div class="col-md-6 mb-3 mb-md-0">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-brio-green text-white py-3">
              <h5 class="mb-0"><i class="fas fa-shopping-basket me-2"></i> Ingredientes</h5>
            </div>
            <div class="card-body p-4">
              <ul class="list-unstyled">
                <?php 
                    // Transforma cada linha do banco em um item da lista com check
                    $listaIngredientes = explode("\n", $receita['ingredientes']);
                    foreach($listaIngredientes as $item):
                        if(trim($item) != ''):
                ?>
                    <li class="mb-2 border-bottom pb-2">
                        <i class="fas fa-check-circle text-success me-2"></i> <?php echo htmlspecialchars($item); ?>
                    </li>
                <?php endif; endforeach; ?>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-brio-green text-white py-3">
              <h5 class="mb-0"><i class="fas fa-fire-alt me-2"></i> Modo de Preparo</h5>
            </div>
            <div class="card-body p-4">
                <ol class="list-group list-group-numbered list-group-flush">
                <?php 
                    $listaPreparo = explode("\n", $receita['modo_preparo']);
                    foreach($listaPreparo as $passo):
                        if(trim($passo) != ''):
                ?>
                    <li class="list-group-item border-0 ps-2 mb-2">
                        <?php echo htmlspecialchars($passo); ?>
                    </li>
                <?php endif; endforeach; ?>
                </ol>
            </div>
          </div>
        </div>
      </div>

      <?php if(count($relacionadas) > 0): ?>
      <div class="row">
        <div class="col-12">
          <h3 class="text-brio-green mb-4">Você também pode gostar</h3>
          <div class="row g-4">
            <?php foreach($relacionadas as $rel): 
                $imgRel = !empty($rel['imagem']) ? "../" . $rel['imagem'] : "https://placehold.co/600x400/e9ecef/4a572c?text=Sem+Foto";
            ?>
            <div class="col-md-6 col-lg-3">
              <div class="card h-100 shadow-sm border-0 overflow-hidden">
                <img src="<?php echo $imgRel; ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?php echo htmlspecialchars($rel['nome']); ?>">
                <div class="card-body">
                  <h6 class="card-title text-truncate"><?php echo htmlspecialchars($rel['nome']); ?></h6>
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted"><i class="fas fa-clock"></i> <?php echo $rel['tempo_preparo_minutos']; ?>m</small>
                    <a href="verReceita.php?id=<?php echo $rel['id']; ?>" class="btn btn-sm btn-outline-success">Ver</a>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>

    </div>

    <script src="../js/components.js"></script>
    <script>
      carregarHeader("Brio");
      carregarFooter();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function compartilharReceita() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo htmlspecialchars($receita['nome']); ?>',
                    text: 'Confira esta receita incrível no Brio!',
                    url: window.location.href,
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert("Link copiado para a área de transferência!");
            }
        }

        function toggleFavorito(receitaId, btn) {
            fetch("../php/favoritos.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `receita_id=${receitaId}&action=toggle`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = btn.querySelector("i");
                    const text = btn.querySelector("#txt-favorito");
                    
                    if (data.is_favorito) {
                        btn.classList.remove("btn-outline-danger");
                        btn.classList.add("btn-danger");
                        icon.classList.remove("far");
                        icon.classList.add("fas");
                        text.innerText = "Favoritado";
                    } else {
                        btn.classList.remove("btn-danger");
                        btn.classList.add("btn-outline-danger");
                        icon.classList.remove("fas");
                        icon.classList.add("far");
                        text.innerText = "Favoritar";
                    }
                } else {
                    alert("Erro ao favoritar. Faça login primeiro.");
                }
            })
            .catch(err => console.error(err));
        }
    </script>
  </body>
</html>