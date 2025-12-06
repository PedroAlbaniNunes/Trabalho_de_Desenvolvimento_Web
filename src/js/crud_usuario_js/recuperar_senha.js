window.onload = function () {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("sucesso_envio")) {
    document.getElementById("modal-sucesso-envio").style.display = "flex";
  } else if (urlParams.has("erro")) {
    const tipoErro = urlParams.get("erro");
    let mensagem = "Ocorreu um erro no sistema. Tente novamente.";
    if (tipoErro === "email_nao_encontrado") {
      mensagem = "E-mail não encontrado.";
    } else if (tipoErro === "erro_envio_email") {
      mensagem = "Erro ao tentar enviar e-mail. Tente mais tarde.";
    }
    document.getElementById("mensagem-erro").innerText = mensagem;
    document.getElementById("modal-erro").style.display = "flex";
  }
};

function fecharModal(idModal) {
  document.getElementById(idModal).style.display = "none";
  window.history.replaceState({}, document.title, window.location.pathname);
}
