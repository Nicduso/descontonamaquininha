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

function debounce(func, delay) {
	let timeout;
	return function (...args) {
		clearTimeout(timeout);
		timeout = setTimeout(() => func.apply(this, args), delay);
	};
}

document.addEventListener('DOMContentLoaded', () => {
	loadProducts();

	const searchInput = document.getElementById('search-input');

	const debouncedSearch = debounce(function () {
		const value = searchInput.value.trim();
		if (value.length >= 3) {
			loadProducts(value);
		} else if (value.length === 0) {
			loadProducts();
		}
	}, 500);

	searchInput.addEventListener('input', debouncedSearch);
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
	const debouncedPublicSearch = debounce(function () {
		const query = searchInput.value.trim();
		const brand = operatorSelect.value;
		if (query.length >= 3) {
			loadPublicProducts(query, brand);
		} else if (query.length === 0) {
			loadPublicProducts('', brand);
		}
	}, 500);

	searchInput.addEventListener('input', debouncedPublicSearch);

	operatorSelect.addEventListener('change', () => {
		const query = searchInput.value.trim();
		if (query.length >= 3 || query.length === 0) {
			loadPublicProducts(query, operatorSelect.value);
		}
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
