let currentPage = 1;

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const categoria = urlParams.get("categoria");
  const busca = urlParams.get("busca");

  if (categoria) {
    const catSelect = document.getElementById("categoria");
    if (catSelect) catSelect.value = categoria;
  }
  if (busca) {
    const buscaInput = document.getElementById("busca");
    if (buscaInput) buscaInput.value = busca;
  }

  buscarReceitas();

  // Adicionar evento de Enter na busca
  const buscaInput = document.getElementById("busca");
  if (buscaInput) {
    buscaInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        buscarReceitas(1);
      }
    });
  }
});

function buscarReceitas(page = 1) {
  currentPage = page;
  const buscaElement = document.getElementById("busca");
  const categoriaElement = document.getElementById("categoria");

  const busca = buscaElement ? buscaElement.value : "";
  const categoria = categoriaElement ? categoriaElement.value : "";

  // Mostrar loading
  const loading = document.getElementById("loading");
  const container = document.getElementById("receitas-container");

  if (loading) loading.style.display = "block";
  if (container) container.style.display = "none";

  // Construir URL
  const params = new URLSearchParams({
    ajax: "1",
    page: page,
  });

  if (busca) params.append("busca", busca);
  if (categoria) params.append("categoria", categoria);

  fetch(`../php/listarReceitas.php?${params}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        throw new Error(data.error);
      }

      renderReceitas(data.receitas);
      renderPaginacao(data.pagination);

      if (loading) loading.style.display = "none";
      if (container) container.style.display = "flex";
    })
    .catch((error) => {
      console.error("Erro ao carregar receitas:", error);
      if (container) {
        container.innerHTML =
          '<div class="col-12 text-center"><p class="text-danger">Erro ao carregar receitas. Tente novamente.</p></div>';
        container.style.display = "flex";
      }
      if (loading) loading.style.display = "none";
    });
}

function renderReceitas(receitas) {
  const container = document.getElementById("receitas-container");
  if (!container) return;

  if (receitas.length === 0) {
    container.innerHTML =
      '<div class="col-12 text-center"><p class="text-muted">Nenhuma receita encontrada.</p></div>';
    return;
  }

  container.innerHTML = receitas
    .map((receita) => {
      // Lógica da Imagem: Se tiver no banco usa, senão usa placeholder
      let imagemUrl = receita.imagem
        ? "../" + receita.imagem
        : "https://placehold.co/600x400/e9ecef/4a572c?text=Sem+Foto";

      return `
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm overflow-hidden">
            
            <div style="height: 200px; overflow: hidden; background-color: #f8f9fa;">
                <img 
                    src="${imagemUrl}" 
                    class="card-img-top w-100 h-100" 
                    alt="${receita.nome}" 
                    style="object-fit: cover;"
                    onerror="this.src='https://placehold.co/600x400?text=Erro+Imagem';"
                >
            </div>

            <div class="card-body">
              <h5 class="card-title text-brio-green">${receita.nome}</h5>
              <p class="card-text text-muted small">Por: ${
                receita.autor_nome
              }</p>
              <p class="card-text">${receita.descricao.substring(0, 100)}${
        receita.descricao.length > 100 ? "..." : ""
      }</p>
              
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary">${receita.categoria}</span>
                <small class="text-muted"><i class="fas fa-clock"></i> ${
                  receita.tempo_preparo_minutos
                } min</small>
              </div>
              
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="badge bg-info">Nível ${receita.dificuldade}</span>
                <div>
                  <button class="btn btn-sm btn-outline-danger me-2" onclick="toggleFavorito(${
                    receita.id
                  }, this)">
                    <i class="fas fa-heart"></i>
                  </button>
                  <a href="../php/verReceita.php?id=${
                    receita.id
                  }" class="btn btn-sm btn-success">Ver Receita</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;
    })
    .join("");
}

function renderPaginacao(pagination) {
  const container = document.getElementById("pagination");
  if (!container) return;

  if (pagination.total_pages <= 1) {
    container.innerHTML = "";
    return;
  }

  let html = "";

  if (pagination.has_prev) {
    html += `<li class="page-item"><a class="page-link" href="#" onclick="buscarReceitas(${
      pagination.current_page - 1
    })">Anterior</a></li>`;
  }

  for (let i = 1; i <= pagination.total_pages; i++) {
    const activeClass = i === pagination.current_page ? "active" : "";
    if (i === pagination.current_page) {
      html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
    } else {
      html += `<li class="page-item"><a class="page-link" href="#" onclick="buscarReceitas(${i})">${i}</a></li>`;
    }
  }

  if (pagination.has_next) {
    html += `<li class="page-item"><a class="page-link" href="#" onclick="buscarReceitas(${
      pagination.current_page + 1
    })">Próximo</a></li>`;
  }

  container.innerHTML = html;
}

function limparFiltros() {
  const busca = document.getElementById("busca");
  const cat = document.getElementById("categoria");
  if (busca) busca.value = "";
  if (cat) cat.value = "";
  buscarReceitas(1);
}

function toggleFavorito(receitaId, button) {
  fetch("../php/favoritos.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `receita_id=${receitaId}&action=toggle`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const icon = button.querySelector("i");
        if (data.is_favorito) {
          button.classList.remove("btn-outline-danger");
          button.classList.add("btn-danger");
          icon.classList.add("fas");
          icon.classList.remove("far");
        } else {
          button.classList.remove("btn-danger");
          button.classList.add("btn-outline-danger");
          icon.classList.remove("fas");
          icon.classList.add("far");
        }
      } else {
        alert(data.error || "Erro ao atualizar favoritos");
      }
    })
    .catch((error) => {
      console.error("Erro:", error);
      alert("Erro ao atualizar favoritos");
    });
}
