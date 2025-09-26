function loadProducts(title = '') {
  fetch(`../../src/controller/search_products.php?title=${encodeURIComponent(title)}`)
    .then(response => response.text())
    .then(html => {
      const table = document.querySelector('.products-list table');
      if (table) {
        table.innerHTML = `
          <tr class="title-row">
            <th class="id-title">ID</th>
            <th class="table-title">Operadora</th>
            <th class="table-title">Maquininha</th>
            <th class="table-title" colspan="2">Ação</th>
          </tr>
          ${html}
        `;
      }
    });
}

function fillForm(product) {
  document.getElementById('form-id').value = product.id;
  document.querySelector('[name="brand"]').value = product.brand_name;
  document.querySelector('[name="title"]').value = product.title;
  document.querySelector('[name="discount"]').value = product.discount;
  document.querySelector('[name="link_promo"]').value = product.link_promo;
  document.querySelector('[name="more_info"]').value = product.more_info;

  document.querySelector('[name="includes"]').value = product.includes || '';
  document.querySelector('[name="screen"]').value = product.screen || '';
  document.querySelector('[name="resolution"]').value = product.resolution || '';
  document.querySelector('[name="battery"]').value = product.battery || '';
  document.querySelector('[name="connections"]').value = product.connections || '';
  document.querySelector('[name="processor"]').value = product.processor || '';
  document.querySelector('[name="weight"]').value = product.weight || '';
  document.querySelector('[name="dimensions"]').value = product.dimensions || '';
  document.querySelector('[name="memories"]').value = product.memories || '';
  document.querySelector('[name="operating_system"]').value = product.operating_system || '';
  document.querySelector('[name="free_shipping"]').value = product.free_shipping || '';

  const container = document.getElementById('taxes-container');
  container.innerHTML = '';
  taxIndex = 0;

  fetch(`../../src/controller/get_taxes.php?product_id=${product.product_id}`)
    .then(response => response.json())
    .then(taxes => {
      taxes.forEach(tax => {
        const block = document.createElement('div');
        block.className = 'tax-block';
        block.innerHTML = `
          <input type="text" name="taxes[${taxIndex}][billing]" value="${tax.billing}" placeholder="Cobrança">
          <input type="text" name="taxes[${taxIndex}][debit]" value="${tax.debit}" placeholder="Débito">
          <input type="text" name="taxes[${taxIndex}][credit]" value="${tax.credit}" placeholder="Crédito">
          <input type="text" name="taxes[${taxIndex}][other]" value="${tax.other}" placeholder="Outros">
        `;
        container.appendChild(block);
        taxIndex++;
      });
    });
}

function debounce(func, delay) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), delay);
  };
}

document.addEventListener('DOMContentLoaded', () => {
  const adminSearchInput = document.getElementById('search-input');
  const adminTable = document.querySelector('.products-list table');

  if (adminSearchInput && adminTable) {
    loadProducts();

    const debouncedSearch = debounce(function () {
      const value = adminSearchInput.value.trim();
      if (value.length >= 3) {
        loadProducts(value);
      } else if (value.length === 0) {
        loadProducts();
      }
    }, 500);

    adminSearchInput.addEventListener('input', debouncedSearch);
  }

  const publicSearchInput = document.querySelector('.search-input');
  const operatorSelect = document.querySelector('.operator-select');

  if (publicSearchInput && operatorSelect) {
    const debouncedPublicSearch = debounce(function () {
      const query = publicSearchInput.value.trim();
      const brand = operatorSelect.value;
      if (query.length >= 3) {
        loadPublicProducts(query, brand);
      } else if (query.length === 0) {
        loadPublicProducts('', brand);
      }
    }, 500);

    publicSearchInput.addEventListener('input', debouncedPublicSearch);

    operatorSelect.addEventListener('change', () => {
      const query = publicSearchInput.value.trim();
      if (query.length >= 3 || query.length === 0) {
        loadPublicProducts(query, operatorSelect.value);
      }
    });

    loadPublicProducts();
  }
});

function loadPublicProducts(query = '', brand = '') {
  fetch(`src/controller/search_cards.php?query=${encodeURIComponent(query)}&brand_name=${encodeURIComponent(brand)}`)
    .then(response => response.text())
    .then(html => {
      const cardList = document.querySelector('.card-list');
      if (cardList) {
				cardList.innerHTML = html;

				if (!html.trim()) {
					cardList.innerHTML = '<p class="product-not-found">Nenhum produto foi encontrado.</p>';
				}
      }
    });
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

let taxIndex = 1;
function addTaxBlock() {
  const container = document.getElementById('taxes-container');
  const block = document.createElement('div');
  block.className = 'tax-block';
  block.innerHTML = `
    <div class="input-tax"><input type="text" name="taxes[${taxIndex}][billing]" placeholder="Cobrança"></div>
    <div class="input-tax"><input type="text" name="taxes[${taxIndex}][debit]" placeholder="Débito"></div>
    <div class="input-tax"><input type="text" name="taxes[${taxIndex}][credit]" placeholder="Crédito"></div>
    <div class="input-tax"><input type="text" name="taxes[${taxIndex}][other]" placeholder="Outros"></div>
    <button class="remove-tax" onclick="this.parentElement.remove()">Remover</button>
  `;
  container.appendChild(block);
  taxIndex++;
}
