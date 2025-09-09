<?php
require_once __DIR__ . '/public/php/model/Register.class.php';
require_once __DIR__ . '/public/php/controller/DAO.class.php';

$dao = new DAO();
$products = $dao->listAll();
$brands = $dao->getUniqueBrands();
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
								<?php foreach ($brands as $brand): ?>
									<option value="<?= htmlspecialchars($brand) ?>"><?= htmlspecialchars($brand) ?></option>
								<?php endforeach; ?>
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
					<?php include 'public/php/view/render_cards.php'; ?>
				</div>
			</div>
		</main>
		<script src="public/js/script.js"></script>
		<?php if (!empty($successMessage)): ?>
			<script>
				loadPublicProducts();
			</script>
		<?php endif; ?>
		<a href="public/php/view/product_comparation.php" class="floating-button" title="Comparar produtos">
			<i class="material-icons compare-icon">compare</i>
			<span class="button-label">Comparar produtos</span>
		</a>
	</body>
</html>
