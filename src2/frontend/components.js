function carregarHeader(titulo = "Brio") { //já coloquei bootstrap no header e footer tmb
    const headerHTML = `
    <header class="navbar navbar-expand bg-brio-green text-white py-3 shadow-sm">
      <div class="container">
        <div class="navbar-brand text-white font-serif fs-3 me-auto">
          ${titulo}
        </div>
  
        <div class="d-flex align-items-center gap-1">

          <a href="ultimas_receitas.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class=" "></i> <span>Últimas Receitas</span>
          </a>
          <a href="airfryer.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class=" "></i> <span>Air Fryer</span>
          </a>          
          <a href="pasta.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class=" "></i> <span>Pasta</span>
          </a>
          <a href="snacks.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class=" "></i> <span>Snacks</span>
          </a>
          
          <a href="adicionar_receita.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
            <i class="fas fa-plus-circle"></i> <span>Adicionar</span>
          </a>
          <a href="salvas.html" class="d-none d-md-flex align-items-center gap-2 btn btn-link text-white text-decoration-none">
             <i class="fas fa-heart"></i> <span>Salvas</span>
          </a>
          <div class="rounded-circle bg-white" style="width: 40px; height: 40px;"></div>
        </div>
      </div>
    </header>
    `;
    
    document.body.insertAdjacentHTML('afterbegin', headerHTML);
}

function carregarFooter() {
    const footerHTML = `
    <footer class="bg-brio-green text-white text-center py-4 mt-auto">
      <div class="container">
        <p class="mb-0">© 2025 Brio - Coma Bem e Emagreça. Todos os direitos reservados.</p>
      </div>
    </footer>
    `;

    document.body.insertAdjacentHTML('beforeend', footerHTML);
}