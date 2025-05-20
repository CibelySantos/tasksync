<?php
session_start();

$host = 'localhost'; 
$user = 'root';
$password = ''; 
$dbname = 'tasksync'; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_usuarios = mysqli_real_escape_string($conn, $_POST['nome_usuarios']);
    $senha_usuarios = mysqli_real_escape_string($conn, $_POST['senha_usuarios']);

    $sql_check = "SELECT id_usuarios FROM usuarios WHERE nome_usuarios = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $nome_usuarios);
    $stmt_check->execute();
    $stmt_check->store_result();

        $senha_hash = password_hash($senha_usuarios, PASSWORD_DEFAULT);

        $sql_insert = "INSERT INTO usuarios (nome_usuarios, senha_usuarios) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $nome_usuarios, $senha_hash);

        if ($stmt_insert->execute()) {
            $_SESSION['status'] = 'sucesso';
        } else {
            $_SESSION['status'] = 'erro';
            $_SESSION['erro_msg'] = $conn->error;
        }
        $stmt_insert->close();

    $stmt_check->close();
    $conn->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastro</title>
    <link rel="stylesheet" href="./css/cadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo-nav">
            <img src="./img/logo.png" alt="Logo TaskSync">
        </div>
    </header>

    <div class="cadastro">
        <img src="./img/logo.png" alt="Logo TaskSync" class="logo">

        <form method="POST">
            <label for="nome_usuarios">Nome:</label>
            <input type="text" id="nome_usuarios" name="nome_usuarios" required placeholder="Digite seu nome"><br><br>
    
            <label for="senha_usuarios">Senha:</label>
            <input type="password" id="senha_usuarios" name="senha_usuarios" required minlength="6" placeholder="No mínimo 6 caracteres"><br><br>
    
            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <?php if (isset($_SESSION['status'])): ?>
        <script>
            <?php if ($_SESSION['status'] == 'sucesso'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastro realizado com sucesso!',
                    text: 'O usuário foi registrado com sucesso.',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            <?php elseif ($_SESSION['status'] == 'nome_existente'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Erro ao cadastrar',
                    text: 'Este nome já está cadastrado. Tente outro.',
                    confirmButtonText: 'Ok'
                });
            <?php elseif ($_SESSION['status'] == 'erro'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao cadastrar',
                    text: <?= json_encode($_SESSION['erro_msg']); ?>,
                    confirmButtonText: 'Tentar novamente'
                });
            <?php endif; ?>
        </script>
        <?php 
        unset($_SESSION['status'], $_SESSION['erro_msg']);
        ?>
    <?php endif; ?>
</body>
</html>
