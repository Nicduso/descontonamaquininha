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

			$brandName = trim($_POST['brand']);
			$brandId = $dao->getOrCreateBrandId($brandName);
			$product->setBrandId($brandId);
			$product->setBrandName($brandName);

			$product->setTitle($_POST['title']);
			$product->setDiscount($_POST['discount']);
			$product->setLinkPromo($_POST['link_promo']);
			$product->setMoreInfo($_POST['more_info']);

			$product->setIncludes($_POST['includes']);
			$product->setScreen($_POST['screen']);
			$product->setResolution($_POST['resolution']);
			$product->setBattery($_POST['battery']);
			$product->setConnections($_POST['connections']);
			$product->setProcessor($_POST['processor']);
			$product->setWeight($_POST['weight']);
			$product->setDimensions($_POST['dimensions']);
			$product->setMemories($_POST['memories']);
			$product->setOperatingSystem($_POST['operating_system']);
			$product->setFreeShipping($_POST['free_shipping']);

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

			$taxes = $_POST['taxes'] ?? [];

			if ($action == 'Cadastrar') {
				$dao->insertFull($product, $taxes);
				$successMessage = 'Produto cadastrado com sucesso!';
			} elseif ($action == 'Alterar') {
				$id = $_POST['id'];
				$dao->modifyFull($id, $product, $taxes);
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

					<h2 class="form-subtitle">Ficha Técnica:</h2>
						<div class="form-line">
							<label class="label-form">Inclui:</label>
							<div class="normal-input-text"><input type="text" name="includes"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Tela:</label>
							<div class="normal-input-text"><input type="text" name="screen"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Resolução:</label>
							<div class="normal-input-text"><input type="text" name="resolution"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Bateria:</label>
							<div class="normal-input-text"><input type="text" name="battery"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Conexões:</label>
							<div class="normal-input-text"><input type="text" name="connections"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Processador:</label>
							<div class="normal-input-text"><input type="text" name="processor"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Peso:</label>
							<div class="normal-input-text"><input type="text" name="weight"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Dimensões:</label>
							<div class="normal-input-text"><input type="text" name="dimensions"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Memórias:</label>
							<div class="normal-input-text"><input type="text" name="memories"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Sist. Oper.:</label>
							<div class="normal-input-text"><input type="text" name="operating_system"></div>
						</div>
						<div class="form-line">
							<label class="label-form">Frete:</label>
							<div class="normal-input-text">
								<label class="radio-option">
									<input type="radio" name="free_shipping" value="Sim"> Sim
								</label>
								<label class="radio-option">
									<input type="radio" name="free_shipping" value="Não"> Não
								</label>
							</div>
						</div>

					<h2 class="form-subtitle">Taxas:</h2>
						<div id="taxes-container">
							<div class="tax-block">
								<div class="input-tax"><input type="text" name="taxes[0][billing]" placeholder="Cobrança"></div>
								<div class="input-tax"><input type="text" name="taxes[0][debit]" placeholder="Débito"></div>
								<div class="input-tax"><input type="text" name="taxes[0][credit]" placeholder="Crédito"></div>
								<div class="input-tax"><input type="text" name="taxes[0][other]" placeholder="Outros"></div>
							</div>
						</div>
						<button type="button" onclick="addTaxBlock()" class="add-tax-button">+ Adicionar Taxa</button>

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
			addTaxBlock();
		</script>
	<?php endif; ?>
</body>
</html>
