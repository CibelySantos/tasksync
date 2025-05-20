<?php
include './bd/conexao.php';
session_start();

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($nome) || empty($senha)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {
        $nome = $conn->real_escape_string($nome);
        $query = "SELECT * FROM usuarios WHERE nome_usuarios = '$nome'";
        $resultado = $conn->query($query);

        if ($resultado->num_rows > 0) {
            $usuario_logado = $resultado->fetch_assoc();

            if (password_verify($senha, $usuario_logado['senha_usuarios'])) {
                $_SESSION['usuario_nome'] = $usuario_logado['nome_usuarios'];
                $_SESSION['usuario_id'] = $usuario_logado['id_usuarios'];
                header('Location: gerenctarefa.php');
                exit();
            } else {
                $mensagem = "Senha incorreta. Tente novamente.";
            }
        } else {
            $mensagem = "Usuário não encontrado. Verifique seu nome.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
<header>
    <div class="logo-nav">
        <img src="./img/logo.png" alt="Logo TaskSync">
    </div>
</header>

<div class="login">
    <img src="./img/logo.png" alt="Logo do TaskSync" class="logo">

    <form action="" method="POST">
        <?php if (!empty($mensagem)): ?>
            <div class="error-message"><?= htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>

        <label for="nome">Nome:</label>
        <input name="nome" type="text" required placeholder="Digite seu nome">

        <label for="senha">Senha:</label>
        <input name="senha" type="password" required placeholder="Digite sua senha">

        <button type="submit">Entrar</button>

        <p class="register-link">
            Não possui uma conta? <a href="cadastro.php">Cadastre-se</a>
        </p>
    </form>
</div>
</body>
</html>
