document.addEventListener('DOMContentLoaded', () => {

    const menu = document.querySelector('.menuDropDown');
    const botao = document.querySelector('.menu-btn');
    const icone = botao?.querySelector('i');

    if (!menu || !botao) {
        return;
    }

    botao.addEventListener('click', () => {

        const aberto = menu.classList.toggle('aberto');

        botao.setAttribute(
            'aria-expanded',
            aberto ? 'true' : 'false'
        );

        if (icone) {
            icone.className = aberto
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-bars';
        }

    });


    /* Fecha o menu ao clicar em um link */

    const links = menu.querySelectorAll('a');

    links.forEach(link => {

        link.addEventListener('click', () => {

            menu.classList.remove('aberto');

            botao.setAttribute(
                'aria-expanded',
                'false'
            );

            if (icone) {
                icone.className = 'fa-solid fa-bars';
            }

        });

    });


    /* Fecha o menu ao clicar fora */

    document.addEventListener('click', (evento) => {

        const clicouNoMenu = menu.contains(evento.target);
        const clicouNoBotao = botao.contains(evento.target);

        if (
            !clicouNoMenu &&
            !clicouNoBotao &&
            menu.classList.contains('aberto')
        ) {

            menu.classList.remove('aberto');

            botao.setAttribute(
                'aria-expanded',
                'false'
            );

            if (icone) {
                icone.className = 'fa-solid fa-bars';
            }

        }

    });

});
