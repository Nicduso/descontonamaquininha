function loadProducts(title = '') {
	fetch(`../controller/search_products.php?title=${encodeURIComponent(title)}`)
		.then(response => response.text())
		.then(html => {
			const table = document.querySelector('.products-list table');
			table.innerHTML = `
				<tr class="title-row">
					<th class="id-title">ID</th>
					<th class="table-title">Operadora</th>
					<th class="table-title">Maquininha</th>
					<th class="table-title" colspan="2">Ação</th>
				</tr>
				${html}
			`;
		});
}

function fillForm(product) {
	document.getElementById('form-id').value = product.id;
	document.querySelector('[name="brand"]').value = product.brand;
	document.querySelector('[name="title"]').value = product.title;
	document.querySelector('[name="discount"]').value = product.discount;
	document.querySelector('[name="link_promo"]').value = product.link_promo;
	document.querySelector('[name="more_info"]').value = product.more_info;
	document.getElementById('file-name').textContent = 'Nenhum ficheiro selecionado';

	const submitBtn = document.getElementById('submit-button');
	submitBtn.value = 'Alterar';
	submitBtn.textContent = 'Alterar';
}

document.addEventListener('DOMContentLoaded', () => {
	loadProducts();

	document.getElementById('search-input').addEventListener('input', function () {
		loadProducts(this.value);
	});
});

function loadPublicProducts(query = '', brand = '') {
	fetch(`public/php/controller/search_cards.php?query=${encodeURIComponent(query)}&brand=${encodeURIComponent(brand)}`)
		.then(response => response.text())
		.then(html => {
			const cardList = document.querySelector('.card-list');
			if (cardList) {
				cardList.innerHTML = html;
			}
		});
}

const searchInput = document.querySelector('.search-input');
const operatorSelect = document.querySelector('.operator-select');

if (searchInput && operatorSelect) {
	searchInput.addEventListener('input', () => {
		loadPublicProducts(searchInput.value, operatorSelect.value);
	});

	operatorSelect.addEventListener('change', () => {
		loadPublicProducts(searchInput.value, operatorSelect.value);
	});

	loadPublicProducts();
}

function showDetails(info) {
	const overlay = document.createElement('div');
	overlay.className = 'details-overlay';

	const popup = document.createElement('div');
	popup.className = 'details-popup';
	popup.innerHTML = `
		<h3 class='title-details'>Detalhes do Produto</h3>
		<p>${info}</p>
		<button class="close-details" onclick="document.body.removeChild(document.querySelector('.details-overlay'))">Fechar</button>
	`;

	overlay.appendChild(popup);
	document.body.appendChild(overlay);
}
