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
}

document.addEventListener('DOMContentLoaded', () => {
	loadProducts();

	document.getElementById('search-input').addEventListener('input', function () {
		loadProducts(this.value);
	});
});
