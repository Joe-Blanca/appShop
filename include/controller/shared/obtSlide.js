
function carregarSlides() {
    
    fetch('/shop/appShop/include/model/shared/obtComponents.php?pagina=home')
        .then(response => response.json())
        .then(data => {
            const slideHome = document.getElementById('slideHome');

            data.forEach(slide => {if (slide.tipo === 'slide') {
                const novoSlide = document.createElement('div');
                novoSlide.className = 'carousel-item position-relative';
                novoSlide.style.height = '430px';

                const imagem = document.createElement('img');
                imagem.className = 'position-absolute w-100 h-100';
                imagem.src = slide.url_img;
                imagem.style.objectFit = 'cover';

                const caption = document.createElement('div');
                caption.className = 'carousel-caption d-flex flex-column align-items-center justify-content-center';

                const conteudo = document.createElement('div');
                conteudo.className = 'p-3';
                conteudo.style.maxWidth = '700px';

                const titulo = document.createElement('h1');
                titulo.className = 'display-4 text-white mb-3 animate__animated animate__fadeInDown';
                titulo.innerText = slide.titulo;

                const texto = document.createElement('p');
                texto.className = 'mx-md-5 px-5 animate__animated animate__bounceIn';
                texto.innerText = slide.descricao;

                const link = document.createElement('a');
                link.className = 'btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp';
                link.href = slide.link;
                link.innerText = 'Comprar Agora';

                
                conteudo.appendChild(titulo);
                conteudo.appendChild(texto);
                conteudo.appendChild(link);
                caption.appendChild(conteudo);
                novoSlide.appendChild(imagem);
                novoSlide.appendChild(caption);

                slideHome.appendChild(novoSlide);
        }});

            // Definir o primeiro slide como ativo
            const primeiroSlide = document.querySelector('.carousel-item');
            primeiroSlide.classList.add('active');
        })
        .catch(error => console.error('Erro ao carregar os slides:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    carregarSlides();
});
    