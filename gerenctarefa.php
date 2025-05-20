<?php 
include './bd/conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action'])) {
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
            $_SESSION['edit_success'] = true;
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

            $stmt = $conn->prepare("UPDATE tarefas SET setor_tarefas=?, prioridade_tarefas=?, datacriacao_tarefas=?, descricao_tarefas=?, status_tarefas=?, id_usuarios=? WHERE id_tarefas=?");
            $stmt->bind_param("ssssssi", $setor, $prioridade, $dataCriacao, $descricao, $status, $usuario, $id);
            $stmt->execute();
            $_SESSION['edit_success'] = true;
            header("Location: gerenctarefa.php");
            exit();
        }

        if ($action === 'delete') {
            $id = $_POST['id_tarefa'];
            $conn->query("DELETE FROM tarefas WHERE id_tarefas = $id");
            $_SESSION['edit_success'] = true;
            header("Location: gerenctarefa.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas</title>
    <link rel="stylesheet" href="./css/gerenctarefa.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
<header>
    <h1 class="text-center my-4">Gerenciador de Tarefas</h1>
</header>

<div class="container">
    <form method="post" action="">
        <input type="hidden" name="action" value="add" id="actionField">
        <input type="hidden" name="id_tarefa" value="" id="idField">

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="setor" class="form-control" placeholder="Setor" required>
            </div>
            <div class="col">
                <select name="prioridade" class="form-control" required>
                    <option value="">Prioridade</option>
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <div class="col">
                <input type="date" name="datacriacao" class="form-control" required>
            </div>
        </div>

        <input type="text" name="titulo" class="form-control mb-3" placeholder="Título da tarefa" required>

        <textarea name="descricao" class="form-control mb-3" placeholder="Descrição da tarefa" required></textarea>

        <div class="row mb-3">
            <div class="col">
                <select name="status" class="form-control" required>
                    <option value="">Status</option>
                    <option value="baixa">A fazer</option>
                    <option value="media">Fazendo</option>
                    <option value="alta">Concluida</option>
                </select>
            </div>
            <div class="col">
                <input type="number" name="usuario" class="form-control" placeholder="ID do Usuário" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success" id="submitButton">Salvar</button>
    </form>
    </section>
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