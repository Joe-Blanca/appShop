function carregarCards() {
    fetch('/shop/appShop/include/model/shared/obtComponents.php?pagina=home')
        .then(response => response.json())
        .then(data => {
            const componentHome = document.getElementById('cardPromo');

            data.forEach(component => {
                if (component.tipo === 'card') { 
                    const novoCard = document.createElement('div');
                    novoCard.className = 'product-offer mb-30';
                    novoCard.style.height = '200px';

                    const imagem = document.createElement('img');
                    imagem.className = 'img-fluid';
                    imagem.src = component.url_img;

                    const caption = document.createElement('div');
                    caption.className = 'offer-text';

                    const titulo = document.createElement('h6');
                    titulo.className = 'text-white text-uppercase';
                    titulo.innerText = component.titulo;

                    const texto = document.createElement('h3');
                    texto.className = 'text-white mb-3';
                    texto.innerText = component.descricao;

                    const link = document.createElement('a');
                    link.className = 'btn btn-primary';
                    link.href = component.link;
                    link.innerText = 'Comprar Agora';

                    // Adicionar elementos ao DOM
                    caption.appendChild(titulo);
                    caption.appendChild(texto);
                    caption.appendChild(link);
                    novoCard.appendChild(imagem);
                    novoCard.appendChild(caption);

                    componentHome.appendChild(novoCard);
                }
            });
        })
        .catch(error => console.error('Erro ao carregar os componentes:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    carregarCards();
});
