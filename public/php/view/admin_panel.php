<?php
	session_start();
	require_once '../model/config.php';

	$error = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST['username'];
		$user_password = $_POST['user_password'];

		$conn = Connection::getInstance();
		$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
		$stmt->bindValue(':username', $username);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user && password_verify($user_password, $user['user_password'])) {
			$_SESSION['user'] = $user['username'];
			header('Location: product_registration.php');
			exit;
		} else {
			$error = 'Usuário ou senha inválidos';
		}
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
	<title>Painel Admin</title>
	<link rel="stylesheet" href="../../css/reset.css">
	<link rel="stylesheet" href="../../css/admin_panel.css">
	<link href="https://fonts.googleapis.com/css2?family=Arimo&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<img class="image-logo" src="../../images/logo-mobile-extends.svg" alt="Logo desconto na maquininha">
	</header>
	<main>
		<div class="panel">
			<form action="" class="panel-form" method="POST">
				<h1 class="form-title">Painel Administrativo</h1>
				<div class="form-field"><input type="text" placeholder="Usuário" name="username"></div>
				<div class="form-field"><input type="password" placeholder="Senha" name="user_password"></div>
				<input type="submit" class="form-submit" value="Acessar">
				<?php if ($error): ?><p><?= $error ?></p><?php endif; ?>
			</form>
			<a href="mailto:contact@descontonamaquinha.com.br?subject=Solicitar acesso ao painel administrativo&body=Olá, gostaria de solicitar acesso ao painel administrativo para a inserção de produtos. Meu nome é... e meu CPF é..." target="_blank" class="pass-button">Solicitar acesso</a>
		</div>
	</main>
	<?php if (isset($_GET['logout'])): ?>
		<div class="alert">Logout realizado com sucesso!</div>
	<?php endif; ?>
</body>
</html>
