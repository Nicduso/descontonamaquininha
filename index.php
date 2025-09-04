<?php
require_once __DIR__ . '/public/php/model/Register.class.php';
require_once __DIR__ . '/public/php/controller/DAO.class.php';

$dao = new DAO();
$produtos = $dao->listAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Desconto na Maquininha</title>
		<link rel="stylesheet" href="public/css/reset.css">
		<link rel="stylesheet" href="public/css/style.css">
		<link rel="shortcut icon" href="public/images/favicon.png" type="image/x-icon">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap" rel="stylesheet">
	</head>
	<body>
		<header>
			<div class="container">
				<div class="header-content">
					<img class="header-logo--desktop" src="public/images/logo-desktop.svg" alt="logo desconto na maquininha">
					<div class="search">
						<div class="search-filter">
							<select class="operator-select">
								<option value="" selected>Operadora</option>
								<option value="">Mercado Pago</option>
								<option value="">Stone</option>
								<option value="">Cielo</option>
							</select>
							<div class="arrow-down-icon">
								<i class="material-icons">arrow_drop_down</i>
							</div>
						</div>
						<div class="search-text">
							<i class="material-icons search-icon">search</i>
							<input type="text" class="search-input">
						</div>
					</div>
				</div>
				<img class="header-logo--mobile" src="public/images/logo-mobile-extends.svg" alt="logo desconto na maquininha">
			</div>
		</header>
		<main>
			<div class="container">
				<h1 class="page-title">Escolha a melhor maquininha para você e resgate o desconto!</h1>
				<div class="card-list">
					<?php foreach ($produtos as $produto): ?>
						<div class="card-item">
							<div class="card-content">
								<img class="machine-image" src="<?= $produto->getPhoto() ?>" alt="maquininha <?= htmlspecialchars($produto->getBrand()) ?>">
								<h2 class="machine-title">Você ganhou <?= intval($produto->getDiscount()) ?>% na sua <?= htmlspecialchars($produto->getTitle()) ?>!</h2>
								<a class="machine-link" href="<?= htmlspecialchars($produto->getLinkPromo()) ?>">Compre com desconto aqui!</a>
							</div>
							<button class="card-more">Detalhes</button>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</main>
	</body>
</html>
