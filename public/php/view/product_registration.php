<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: admin_panel.php');
		exit;
	}
	require_once ("../controller/DAO.class.php");
	require_once ("../model/Register.class.php");
	require_once ("../model/Connection.class.php");

		$dao = new DAO();
		$successMessage = '';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$action = $_POST['action'];
			$product = new Register();
			$product->setBrand($_POST['brand']);
			$product->setTitle($_POST['title']);
			$product->setDiscount($_POST['discount']);
			$product->setLinkPromo($_POST['link_promo']);
			$product->setMoreInfo($_POST['more_info']);

			$photoPath = '';
			if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
				$photoName = basename($_FILES['photo']['name']);
				$targetDir = '../../images/products/';
				$targetPath = $targetDir . $photoName;

				if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
					$photoPath = 'public/images/products/' . $photoName;
				}
			}
			$product->setPhoto($photoPath);

			if ($action == 'Cadastrar') {
				$dao->insert($product);
				$successMessage = 'Produto cadastrado com sucesso!';
			} elseif ($action == 'Alterar') {
				$id = $_POST['id'];
				$dao->modify($id, $product);
				$successMessage = 'Produto alterado com sucesso!';
			}
	}

	if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$dao->delete($id);
	}
?>

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
		<form method="POST" action="../controller/logout.php">
			<a href="user_registration.php" class="user-button">Cadastro Usuário</a>
			<button type="submit" class="exit-button">Sair</button>
		</form>
	</header>
	<main>
		<div class="products-panel">
			<div class="products-header">
				<h2 class="panel-title">Produtos cadastrados:</h2>
				<section class="search">
					<i class="material-icons search-icon">search</i>
					<input type="text" class="search-text" id="search-input">
				</section>
			</div>
			<div class="products-list">
				<table></table>
			</div>
		</div>
		<div class="product-container">
				<h1 class="form-title">Cadastro de Produto:</h1>
				<form class="register-form" method="POST" enctype="multipart/form-data" action="product_registration.php">
					<input type="hidden" name="id" id="form-id">
					<div class="form-line">
						<label class="label-form">Operadora:</label>
						<div class="normal-input-text"><input type="text" name="brand" required></div>
					</div>
					<div class="form-line">
						<label class="label-form">Modelo:</label>
						<div class="normal-input-text"><input type="text" name="title" required></div>
					</div>
					<div class="form-line">
						<label class="label-form">Desconto:</label>
						<div class="normal-input-text">
							<input type="text" placeholder="%" name="discount" required>
						</div>
					</div>
					<div class="form-line">
						<label class="label-form">Link:</label>
						<div class="normal-input-text"><input type="text" class="link-text" name="link_promo"></div>
					</div>
					<div class="form-line">
						<label class="label-form">Detalhes:</label>
						<div class="details-text"><textarea class="details-text-input" name="more_info" rows="2"></textarea></div>
					</div>
					<div class="form-line">
						<label class="label-form">Imagem:</label>
					<div class="form-upload upload-container">
						<label for="file-upload" class="custom-upload"><i class="material-icons">upload</i>Escolher imagem</label>
						<input type="file" name="photo" id="file-upload" class="form-file" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Nenhum ficheiro selecionado'">
  					<span id="file-name" class="file-name-custom">Nenhum ficheiro selecionado</span>
					</div>
					</div>
					<div class="form-actions">
						<input type="submit" value="Cadastrar" name="action" class="form-button">
						<input type="submit" value="Alterar" name="action" class="form-button extra-button">
						<input type="reset" value="Limpar campos" class="form-button extra-button">
					</div>
				</form>
			<?php if (!empty($successMessage)): ?>
				<p class="success-message"><?= $successMessage ?></p>
			<?php endif; ?>
			<p class="info-text">Há mais funções acessíveis nas resoluções de desktop.</p>
		</div>
	</main>
	<script src="../../js/script.js"></script>
	<?php if (!empty($successMessage)): ?>
		<script>
			loadProducts();
		</script>
	<?php endif; ?>
</body>
</html>
