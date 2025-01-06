const headerContainer = document.getElementById('header');

fetch('../../src/app/components/header.html')
.then(response => response.text())
.then(headerHTML => {
    const headerContainer = document.getElementById('header');

    const shadow = headerContainer.attachShadow({ mode: 'open' });

    const linkElement = document.createElement('link');
    linkElement.rel = 'stylesheet';
    linkElement.href = '../css/header.css';

    shadow.appendChild(linkElement);
    shadow.innerHTML += headerHTML;
})
.catch(error => console.error('Erro ao carregar o cabeçalho:', error));
