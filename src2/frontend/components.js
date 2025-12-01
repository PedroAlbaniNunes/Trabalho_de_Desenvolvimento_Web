function carregarHeader(titulo = "Brio") { //já coloquei bootstrap no header e footer tmb
    const headerHTML = `
    <header class="navbar navbar-expand bg-brio-green text-white py-3 shadow-sm">
      <div class="container">
        <div class="navbar-brand text-white font-serif fs-3 me-auto">
          ${titulo}
        </div>
  
        <div class="d-flex align-items-center gap-4">
          <div class="d-none d-md-flex align-items-center gap-2 cursor-pointer btn btn-link text-white text-decoration-none">
             <i class="fas fa-plus-circle"></i> <span>Adicionar</span>
          </div>
          <div class="d-none d-md-flex align-items-center gap-2 cursor-pointer btn btn-link text-white text-decoration-none">
             <i class="fas fa-heart"></i> <span>Salvas</span>
          </div>
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