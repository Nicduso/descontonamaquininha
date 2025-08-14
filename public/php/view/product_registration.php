<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
	<title>Manutenção de registros</title>
	<link rel="stylesheet" href="../../css/reset.css">
	<link rel="stylesheet" href="../../css/product_registration.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<img class="image-logo" src="../../images/logo-desktop.svg" alt="Logo desconto na maquininha">
		<button class="exit-button">Sair</button>
	</header>
	<main>
		<div class="products-panel">
			<div class="products-header">
				<h2 class="panel-title">Produtos cadastrados:</h2>
				<section class="search">
					<i class="material-icons search-icon">search</i>
					<input type="text" class="search-text">
				</section>
			</div>
			<div class="products-list">
				<table>
					<tr class="title-row">
						<th class="id-title">ID</th>
						<th class="table-title">Operadora</th>
						<th class="table-title">Maquininha</th>
						<th class="table-title">Ação</th>
					</tr>
					<tr class="content-row">
						<td class="table-content">0000</td>
						<td class="table-content">Mercado Pago</td>
						<td class="table-content">Point Mini</td>
						<td class="table-content"><a href=""><i class="material-icons delete-icon">delete</i></a></td>
					</tr>
					<tr class="content-row">
						<td class="table-content">0000</td>
						<td class="table-content">Mercado Pago</td>
						<td class="table-content">Point Mini</td>
						<td class="table-content"><a href=""><i class="material-icons delete-icon">delete</i></a></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="product-container">
				<h1 class="form-title">Cadastro de Produto:</h1>
				<form class="register-form">
					<div class="form-line">
						<label class="label-form">Operadora:</label>
						<div class="normal-input-text"><input type="text"></div>
					</div>
					<div class="form-line">
						<label class="label-form">Modelo:</label>
						<div class="normal-input-text"><input type="text"></div>
					</div>
					<div class="form-line">
						<label class="label-form">Desconto:</label>
						<div class="normal-input-text">
							<input type="text" placeholder="%">
						</div>
					</div>
					<div class="form-line">
						<label class="label-form">Link:</label>
						<div class="normal-input-text"><input type="text" class="link-text"></div>
					</div>
					<div class="form-line">
						<label class="label-form">Detalhes:</label>
						<div class="details-text"><textarea class="details-text-input" rows="2"></textarea></div>
					</div>
					<div class="form-line">
						<label class="label-form">Imagem:</label>
					<div class="form-upload upload-container">
						<label for="file-upload" class="custom-upload"><i class="material-icons">upload</i>Escolher imagem</label>
						<input type="file" id="file-upload" class="form-file" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Nenhum ficheiro selecionado'">
  					<span id="file-name" class="file-name-custom">Nenhum ficheiro selecionado</span>
					</div>
					</div>
					<div class="form-actions">
						<input type="submit" value="Cadastrar" class="form-button">
						<input type="submit" value="Alterar" class="form-button extra-button">
						<input type="submit" value="Limpar campos" class="form-button extra-button">
					</div>
				</form>
			<p class="info-text">Há mais funções acessíveis nas resoluções de desktop.</p>
		</div>
	</main>
</body>
</html>
