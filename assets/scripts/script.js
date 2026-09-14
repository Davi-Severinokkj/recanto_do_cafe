const modal = document.querySelector('.modal');
const botao = document.querySelector('.menu-btn');

botao.addEventListener('click', () => {
    modal.classList.toggle('aberto');
});