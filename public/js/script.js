document.getElementById('search-input').addEventListener('input', function() {
	const query = this.value;
	fetch(`search_products.php?title=${encodeURIComponent(query)}`)
		.then(response => response.text())
		.then(html => {
			document.querySelector('.products-list table').innerHTML = html;
	});
});

function fillForm(product) {
	document.getElementById('form-id').value = product.id;
	document.querySelector('[name="brand"]').value = product.brand;
	document.querySelector('[name="title"]').value = product.title;
	document.querySelector('[name="discount"]').value = product.discount;
	document.querySelector('[name="link_promo"]').value = product.link_promo;
	document.querySelector('[name="more_info"]').value = product.more_info;
}
