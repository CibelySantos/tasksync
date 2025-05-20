<?php
include './bd/conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $setor = $_POST['setor'];
        $prioridade = $_POST['prioridade'];
        $dataCriacao = $_POST['datacriacao'];
        $descricao = $_POST['descricao'];
        $status = $_POST['status'];
        $usuario = $_POST['usuario'];
        $titulo = $_POST['titulo'];

        $stmt = $conn->prepare("INSERT INTO tarefas (setor_tarefas, prioridade_tarefas, datacriacao_tarefas, descricao_tarefas, status_tarefas, id_usuarios, titulo_tarefas) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $setor, $prioridade, $dataCriacao, $descricao, $status, $usuario, $titulo);
        $stmt->execute();
        $stmt->close();
        header("Location: gerenctarefa.php");
        exit();
    }

    if ($action === 'edit') {
        $id = $_POST['id_tarefa'];
        $setor = $_POST['setor'];
        $prioridade = $_POST['prioridade'];
        $dataCriacao = $_POST['datacriacao'];
        $descricao = $_POST['descricao'];
        $status = $_POST['status'];
        $usuario = $_POST['usuario'];
        $titulo = $_POST['titulo'];

        $stmt = $conn->prepare("UPDATE tarefas SET setor_tarefas=?, prioridade_tarefas=?, datacriacao_tarefas=?, descricao_tarefas=?, status_tarefas=?, id_usuarios=?, titulo_tarefas=? WHERE id_tarefas=?");
        $stmt->bind_param("ssssssis", $setor, $prioridade, $dataCriacao, $descricao, $status, $usuario, $titulo, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: gerenctarefa.php");
        exit();
    }

    if ($action === 'delete') {
        $id = $_POST['id_tarefa'];
        $conn->query("DELETE FROM tarefas WHERE id_tarefas = $id");
        header("Location: gerenctarefa.php");
        exit();
    }
}

// puxar todas as tarefas
$tarefas = [];
$resultado = $conn->query("SELECT * FROM tarefas");

while ($row = $resultado->fetch_assoc()) {
    $tarefas[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="./css/gerenctarefa.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        .kanban-board {
            display: flex;
            gap: 20px;
            justify-content: space-between;
        }

        .kanban-column {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .kanban-column h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .tarefa {
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .tarefa strong {
            display: block;
        }

        .tarefa-buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .tarefa-buttons form {
            display: inline;
        }

        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Gerenciar Tarefas</h1>

    <form method="POST">
        <input type="hidden" name="action" value="add" id="actionField">
        <input type="hidden" name="id_tarefa" value="" id="idField">

        <input type="text" name="setor" placeholder="Setor" required>
        <select name="prioridade" required>
            <option value="">Prioridade</option>
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select>
        <input type="date" name="datacriacao" required>
        <input type="text" name="titulo" placeholder="Título da tarefa" required>
        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <select name="status" required>
            <option value="">Status</option>
            <option value="a_fazer">A fazer</option>
            <option value="fazendo">Fazendo</option>
            <option value="concluida">Concluída</option>
        </select>
        <input type="number" name="usuario" placeholder="ID do usuário" required>
        <button type="submit" id="submitButton">Salvar</button>
    </form>

    <div class="kanban-board">
        <?php
        $colunas = [
            'a_fazer' => 'A Fazer',
            'fazendo' => 'Fazendo',
            'concluida' => 'Concluído'
        ];

        foreach ($colunas as $status => $titulo) {
            echo "<div class='kanban-column'>";
            echo "<h2>$titulo</h2>";

            foreach ($tarefas as $tarefa) {
                if ($tarefa['status_tarefas'] === $status) {
                    echo "<div class='tarefa'>";
                    echo "<strong>{$tarefa['titulo_tarefas']}</strong>";
                    echo "<p>{$tarefa['descricao_tarefas']}</p>";
                    echo "<small>Setor: {$tarefa['setor_tarefas']} | Prioridade: {$tarefa['prioridade_tarefas']}</small><br>";
                    echo "<small>Criado em: {$tarefa['datacriacao_tarefas']}</small>";

                    echo "<div class='tarefa-buttons'>";
                    echo "<button onclick=\"fillEditForm(" .
                        "{$tarefa['id_tarefas']}, " .
                        "'{$tarefa['setor_tarefas']}', " .
                        "'{$tarefa['prioridade_tarefas']}', " .
                        "'{$tarefa['datacriacao_tarefas']}', " .
                        "'{$tarefa['descricao_tarefas']}', " .
                        "'{$tarefa['status_tarefas']}', " .
                        "{$tarefa['id_usuarios']}, " .
                        "'{$tarefa['titulo_tarefas']}'" .
                    ")\">Editar</button>";

                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='action' value='delete'>";
                    echo "<input type='hidden' name='id_tarefa' value='{$tarefa['id_tarefas']}'>";
                    echo "<button type='submit'>Excluir</button>";
                    echo "</form>";
                    echo "</div>";

                    echo "</div>";
                }
            }

            echo "</div>";
        }
        ?>
    </div>

    <script>
        function fillEditForm(id, setor, prioridade, data, descricao, status, usuario, titulo) {
            document.querySelector('[name=setor]').value = setor;
            document.querySelector('[name=prioridade]').value = prioridade;
            document.querySelector('[name=datacriacao]').value = data;
            document.querySelector('[name=descricao]').value = descricao;
            document.querySelector('[name=status]').value = status;
            document.querySelector('[name=usuario]').value = usuario;
            document.querySelector('[name=titulo]').value = titulo;
            document.getElementById('idField').value = id;
            document.getElementById('actionField').value = 'edit';
            document.getElementById('submitButton').innerText = "Salvar Alterações";
        }
    </script>
</body>
</html>
