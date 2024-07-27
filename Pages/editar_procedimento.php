<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: perfil_administrador.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$sqlGetUsers = "SELECT user_id, nome FROM usuarios";
$resultGetUsers = $conn->query($sqlGetUsers);

if (!$resultGetUsers) {
    die("Erro na consulta SQL: " . $conn->error);
}

$selectedUserId = isset($_POST['selected_user_id']) ? $_POST['selected_user_id'] : null;

if ($selectedUserId !== null) {
    $sqlGetUser = "SELECT user_id, nome FROM usuarios WHERE user_id = ?";
    $stmtGetUser = $conn->prepare($sqlGetUser);
    $stmtGetUser->bind_param("i", $selectedUserId);
    $stmtGetUser->execute();
    $resultGetUser = $stmtGetUser->get_result();

    if ($resultGetUser->num_rows > 0) {
        $user = $resultGetUser->fetch_assoc();

        $sqlGetProcedimentos = "SELECT procedimento_id, procedimento_solicitado, procedimento_realizado FROM procedimentos WHERE user_id = ?";
        $stmtGetProcedimentos = $conn->prepare($sqlGetProcedimentos);
        $stmtGetProcedimentos->bind_param("i", $selectedUserId);
        $stmtGetProcedimentos->execute();
        $resultGetProcedimentos = $stmtGetProcedimentos->get_result();

        if ($resultGetProcedimentos->num_rows > 0) {
            $procedimentos = $resultGetProcedimentos->fetch_all(MYSQLI_ASSOC);
        } else {
            echo "Nenhum procedimento encontrado para este usuário.";
        }

        $stmtGetProcedimentos->close();
    } else {
        echo "Usuário não encontrado.";
    }

    $stmtGetUser->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar_procedimento'])) {
    $procedimento_id = $_POST['procedimento_id'];
    $novoProcedimentoSolicitado = $_POST['novo_procedimento_solicitado'];
    $novoProcedimentoRealizado = $_POST['novo_procedimento_realizado'];

    $sqlUpdateProcedimentos = "UPDATE procedimentos SET procedimento_realizado = ?, procedimento_solicitado = ? WHERE procedimento_id = ?";
    $stmtUpdateProcedimentos = $conn->prepare($sqlUpdateProcedimentos);
    $stmtUpdateProcedimentos->bind_param("ssi", $novoProcedimentoRealizado, $novoProcedimentoSolicitado, $procedimento_id);

    $stmtUpdateProcedimentos->execute();

    $stmtUpdateProcedimentos->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Procedimentos</title>
    <link href="style/style.css" rel="stylesheet">
    <style>
        body {
            background: url(images/bgimagem.jpg);
            width: 800px;
        }

        th, td {
    font-size: 13px;
}
    </style>
</head>
<body>

<div class="caixa1">
    <h1>Editar Procedimentos dos Usuários</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="selected_user_id">Selecione o usuário:</label>
        <select name="selected_user_id" id="selected_user_id">
            <?php
            while ($user = $resultGetUsers->fetch_assoc()) {
                echo "<option value='{$user['user_id']}'" . ($selectedUserId == $user['user_id'] ? " selected" : "") . ">{$user['nome']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Selecionar Usuário">
    </form>

    <?php if (isset($procedimentos)): ?>
        <table class="tabela-usuario">
            <br><tr>
                <th>ID Procedimento</th>
                <th>Procedimento Solicitado</th>
                <th>Procedimento Realizado</th>
                <th>Alterar</th>
            </tr>
            <?php foreach ($procedimentos as $procedimento): ?>
                <tr>
                    <td><?php echo $procedimento['procedimento_id']; ?></td>
                    <td><?php echo $procedimento['procedimento_solicitado']; ?></td>
                    <td><?php echo $procedimento['procedimento_realizado']; ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="procedimento_id" value="<?php echo $procedimento['procedimento_id']; ?>">
                            <label for ="novo_procedimento_solicitado">Procedimento</label>
                        <select name="novo_procedimento_solicitado"  id="novo_procedimento_solicitado" required>
                            <option value="Cirurgia">Cirurgia</option>
                            <option value="Periodontia">Periodontia</option>
                            <option value="Dentistica">Dentistica</option>
                            <option value="Endodontia">Endodontia</option>
                        </select>
                            <br><br><label for="novo_procedimento_realizado">Alterar Procedimento Realizado:</label><br>
                            <input type="text" name="novo_procedimento_realizado" required>
                            <input type="submit" name="alterar_procedimento" value="Alterar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p>Clique <a href="perfil_administrador.php"><b>aqui</b></a> para voltar.</p>
</div>
</body>
</html>
