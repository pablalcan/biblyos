document.addEventListener('DOMContentLoaded', function() {
    const carrosselInner = document.querySelector('.livro-carrossel .carrossel-inner');
    const slideCapa = document.querySelector('.carrossel-slide[data-slide-id="capa"]');
    const slideSinopse = document.querySelector('.carrossel-slide[data-slide-id="sinopse"]');
    const btnVirarPagina = document.getElementById('btn-virar-pagina');

    let isCapaVisible = true; // Começa mostrando a capa

    // Garante que a sinopse comece escondida via JS para evitar flashes
    if (slideSinopse) {
        slideSinopse.style.display = 'none';
    }

    // Função para virar a "página"
    function virarPagina() {
        if (isCapaVisible) {
            // Se a capa está visível, mostra a sinopse
            carrosselInner.style.transform = 'rotateY(180deg)';
            setTimeout(() => {
                slideCapa.style.display = 'none';
                slideSinopse.style.display = 'flex'; // Use flex para centralizar conteúdo
                btnVirarPagina.classList.add('flipped'); // Adiciona classe para virar o ">"
            }, 300); // Tempo para o slide começar a virar antes de esconder/mostrar
        } else {
            // Se a sinopse está visível, mostra a capa
            carrosselInner.style.transform = 'rotateY(0deg)';
            setTimeout(() => {
                slideSinopse.style.display = 'none';
                slideCapa.style.display = 'flex'; // Use flex para centralizar conteúdo
                btnVirarPagina.classList.remove('flipped'); // Remove classe para voltar o ">"
            }, 300); // Tempo para o slide começar a virar antes de esconder/mostrar
        }
        isCapaVisible = !isCapaVisible; // Alterna o estado
    }

    // Adiciona o Event Listener ao botão de virar página
    if (btnVirarPagina) {
        btnVirarPagina.addEventListener('click', virarPagina);
    }
});