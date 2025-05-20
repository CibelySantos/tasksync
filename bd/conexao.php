<?php
$host = 'localhost';
$dbname = 'tasksync';
$username = 'root';
$password = ''; 

try {
    $conexao = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync</title>
</head>
<body>
</body>
</html>
