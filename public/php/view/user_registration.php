<?php
session_start();
require_once '../model/config.php';

if (!isset($_SESSION['user'])) {
    header('Location: admin_panel.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['user_password'];

    if (empty($username) || empty($password)) {
        $error = 'Preencha todos os campos.';
    } else {
        $conn = Connection::getInstance();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            $error = 'Usuário já existe.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, user_password) VALUES (:username, :user_password)");
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':user_password', $hashedPassword);
            $stmt->execute();

            $success = 'Usuário cadastrado com sucesso!';
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_panel.php?logout=1');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
		<link rel="stylesheet" href="../../css/user_registration.css">
</head>
<body>
    <header>
        <h1>Cadastro de Usuário</h1>
    </header>
    <main>
        <div class="panel">
            <form method="POST" class="panel-form">
                <div class="form-field">
                    <input type="text" name="username" placeholder="Novo usuário">
                </div>
                <div class="form-field">
                    <input type="password" name="user_password" placeholder="Senha">
                </div>
                <input type="submit" class="form-submit" value="Cadastrar">
                <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
                <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
            </form>

            <div class="panel-links">
                <a href="product_registration.php" class="pass-button">← Voltar para cadastro de produtos</a>
                <a href="?logout=1" class="pass-button">Sair do painel</a>
            </div>
        </div>
    </main>
</body>
</html>
