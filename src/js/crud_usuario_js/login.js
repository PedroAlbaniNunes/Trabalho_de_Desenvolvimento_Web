window.onload = function () {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("login_erro")) {
    document.getElementById("modal-erro").style.display = "flex";
  }
};

function fecharModal() {
  document.getElementById("modal-erro").style.display = "none";
  window.history.replaceState({}, document.title, window.location.pathname);
}
