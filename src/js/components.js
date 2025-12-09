const PROJECT_ROOT = "/Trabalho_de_Desenvolvimento_Web";

const pathPHP = `${PROJECT_ROOT}/src/php/verificar_sessao.php`;

function getLink(caminhoRelativo) {
  const caminhoLimpo = caminhoRelativo.startsWith("/")
    ? caminhoRelativo.slice(1)
    : caminhoRelativo;
  return `${PROJECT_ROOT}/${caminhoLimpo}`;
}

function carregarFooter() {
  const footerHTML = `
      <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
          <p class="mb-0">&copy; 2025 Brio - Receitas e Sabores. Todos os direitos reservados.</p>
          <small>Desenvolvido com <i class="fas fa-heart text-danger"></i></small>
        </div>
      </footer>
    `;
  document.body.insertAdjacentHTML("beforeend", footerHTML);
}

function carregarHeaderLogado(titulo) {
  const headerHTML = `
    <header class="navbar navbar-expand bg-brio-green text-white py-3 shadow-sm">
      <div class="container">
        <div class="navbar-brand text-white font-serif fs-3 me-auto">${titulo}</div>
        <div class="d-flex align-items-center gap-1">
          <a href="${getLink(
            "index.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class=""></i> <span>Home</span>
          </a>

          <a href="${getLink(
            "src/pages/receitas.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-utensils"></i> <span>Todas as Receitas</span>
          </a>
          <a href="${getLink(
            "src/pages/airfryer.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-wind"></i> <span>Air Fryer</span>
          </a>       
          <a href="${getLink(
            "src/pages/pasta.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-pizza-slice"></i> <span>Pasta</span>
          </a>
          <a href="${getLink(
            "src/pages/snacks.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-cookie-bite"></i> <span>Snacks</span>
          </a>   
          <a href="${getLink(
            "src/pages/adicionar_receita.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
            <i class="fas fa-plus-circle"></i> <span>Adicionar</span>
          </a>   
          <a href="${getLink(
            "src/pages/favoritas.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-heart"></i> <span>Favoritas</span>
          </a>
          <a href="${getLink(
            "src/php/crud_usuario_php/logout.php"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
              <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
          </a>
          <div class="rounded-circle bg-white" style="width: 40px; height: 40px;"></div>
        </div>
      </div>
    </header>
    `;
  document.body.insertAdjacentHTML("afterbegin", headerHTML);
}

function carregarHeaderVisitante(titulo) {
  const headerHTML = `
    <header class="navbar navbar-expand bg-brio-green text-white py-3 shadow-sm">
      <div class="container">
        <div class="navbar-brand text-white font-serif fs-3 me-auto">${titulo}</div>
        
        <div class="d-flex align-items-center gap-1">
          <a href="${getLink(
            "index.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class=""></i> <span>Home</span>
          </a>

          <a href="${getLink(
            "src/pages/receitas.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-utensils"></i> <span>Todas</span>
          </a>

          <a href="${getLink(
            "src/pages/airfryer.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-wind"></i> <span>Air Fryer</span>
          </a>          

          <a href="${getLink(
            "src/pages/pasta.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-pizza-slice"></i> <span>Pasta</span>
          </a>

          <a href="${getLink(
            "src/pages/snacks.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-cookie-bite"></i> <span>Snacks</span>
          </a>

          <a href="${getLink(
            "src/pages/crud_usuario/login.html"
          )}" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
              <i class="fas fa-sign-in-alt"></i> <span>Entrar</span>
          </a>
        </div>
      </div>
    </header>
    `;
  document.body.insertAdjacentHTML("afterbegin", headerHTML);
}

async function carregarComponentes(titulo = "Brio") {
  try {
    // TRUQUE DO TIMESTAMP: ?t=12345
    // Isso força o navegador a baixar o arquivo PHP de novo e não usar cache velho
    const timestamp = new Date().getTime();
    const urlComCache = `${pathPHP}?t=${timestamp}`;

    const resposta = await fetch(urlComCache);

    if (!resposta.ok) throw new Error(`Erro HTTP: ${resposta.status}`);

    const dados = await resposta.json();

    // Verifica se logado é TRUE
    if (dados.logado === true) {
      carregarHeaderLogado(titulo);
    } else {
      carregarHeaderVisitante(titulo);
    }
  } catch (erro) {
    console.error("Erro components.js:", erro);
    carregarHeaderVisitante(titulo);
  } finally {
    carregarFooter();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  carregarComponentes("Brio");
});
