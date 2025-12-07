function carregarHeader(titulo = "Brio") {
  //já coloquei bootstrap no header e footer tmb
  const headerHTML = `
    <header class="navbar navbar-expand bg-brio-green text-white py-3 shadow-sm">
      <div class="container">
        <div class="navbar-brand text-white font-serif fs-3 me-auto">
          ${titulo}
        </div>
  
        <div class="d-flex align-items-center gap-1">

          <a href="../pages/receitas.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-utensils"></i> <span>Todas as Receitas</span>
          </a>
          <a href="../pages/airfryer.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-wind"></i> <span>Air Fryer</span>
          </a>          
          <a href="../pages/receitas.html?categoria=Massa" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-pizza-slice"></i> <span>Pasta</span>
          </a>
          <a href="../pages/receitas.html?categoria=Lanche" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-cookie-bite"></i> <span>Snacks</span>
          </a>
          
          <a href="../pages/adicionar_receita.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
            <i class="fas fa-plus-circle"></i> <span>Adicionar</span>
          </a>
          <a href="../pages/favoritas.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-heart"></i> <span>Favoritas</span>
          </a>
          <a href="../php/crud_usuario_php/logout.php" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
              <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
          </a>
          <div class="rounded-circle bg-white" style="width: 40px; height: 40px;"></div>
        </div>
      </div>
    </header>
    `;

  document.body.insertAdjacentHTML("afterbegin", headerHTML); //
}

function carregarHeaderTelaInicial(titulo = "Brio") {
  //
  const headerHTML = `
    <header class="navbar navbar-expand bg-brio-green text-white py-3 shadow-sm">
      <div class="container">
        <div class="navbar-brand text-white font-serif fs-3 me-auto">
          ${titulo}
        </div>
  
        <div class="d-flex align-items-center gap-1">

          <a href="src/pages/receitas.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-utensils"></i> <span>Todas as Receitas</span>
          </a>
          <a href="src/pages/airfryer.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-wind"></i> <span>Air Fryer</span>
          </a>          
          <a href="src/pages/pasta.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-pizza-slice"></i> <span>Pasta</span>
          </a>
          <a href="src/pages/snacks.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-cookie-bite"></i> <span>Snacks</span>
          </a>
          
          <a href="src/pages/crud_usuario/login.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
              <i class="fas fa-sign-out-alt"></i> <span>Entrar</span>
          </a>
        </div>
      </div>
    </header>
    `;

  document.body.insertAdjacentHTML("afterbegin", headerHTML); //
}

function carregarFooter() {
  //
  const footerHTML = `
    <footer class="bg-brio-green text-white text-center py-4 mt-auto">
      <div class="container">
        <p class="mb-0">© 2025 Brio - Coma Bem e Emagreça. Todos os direitos reservados.</p>
      </div>
    </footer>
    `;

  document.body.insertAdjacentHTML("beforeend", footerHTML); //
}
