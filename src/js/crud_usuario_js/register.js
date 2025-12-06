window.onload = function () {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("sucesso")) {
    document.getElementById("modal-sucesso").style.display = "flex";
  }

  if (urlParams.has("erro")) {
    const tipoErro = urlParams.get("erro");
    const msg = document.getElementById("mensagem-erro");

    if (tipoErro === "email_existe") {
      msg.innerText = "Este e-mail já está cadastrado.";
    } else {
      msg.innerText = "Erro no sistema. Tente novamente.";
    }
    document.getElementById("modal-erro").style.display = "flex";
  }
};

function fecharModal(idModal) {
  document.getElementById(idModal).style.display = "none";
  window.history.replaceState({}, document.title, window.location.pathname);
}

function irParaLogin() {
  window.location.href = "login.html";
}
