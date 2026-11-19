// Máscaras simples (CEP e telefone)
document.querySelectorAll('[data-mask]').forEach(function (el) {
  el.addEventListener('input', function () {
    var d = el.value.replace(/\D/g, '');
    if (el.dataset.mask === 'cep') {
      d = d.slice(0, 8);
      el.value = d.length > 5 ? d.slice(0, 5) + '-' + d.slice(5) : d;
    } else if (el.dataset.mask === 'tel') {
      d = d.slice(0, 11);
      if (d.length > 6) el.value = '(' + d.slice(0, 2) + ') ' + d.slice(2, d.length - 4) + '-' + d.slice(-4);
      else if (d.length > 2) el.value = '(' + d.slice(0, 2) + ') ' + d.slice(2);
      else el.value = d;
    }
  });
});

// Frete: adiciona/remove linhas de produto dinamicamente
var lista = document.getElementById('itens');
var modelo = document.getElementById('modelo-item');
if (lista && modelo) {
  function adicionarItem() {
    lista.appendChild(modelo.content.cloneNode(true));
    atualizarBotoes();
  }
  function atualizarBotoes() {
    var linhas = lista.querySelectorAll('.item-linha');
    linhas.forEach(function (l) { l.querySelector('.btn-remover').disabled = linhas.length === 1; });
  }
  document.getElementById('btn-add').addEventListener('click', adicionarItem);
  lista.addEventListener('click', function (ev) {
    var b = ev.target.closest('.btn-remover');
    if (b && !b.disabled) { b.closest('.item-linha').remove(); atualizarBotoes(); }
  });
  adicionarItem();
}
