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

        $sqlGetConsultas = "SELECT id, data_consulta, horario FROM consultas WHERE user_id = ?";
        $stmtGetConsultas = $conn->prepare($sqlGetConsultas);
        $stmtGetConsultas->bind_param("i", $selectedUserId);
        $stmtGetConsultas->execute();
        $resultGetConsultas = $stmtGetConsultas->get_result();

        if ($resultGetConsultas->num_rows > 0) {
            $consultas = $resultGetConsultas->fetch_all(MYSQLI_ASSOC);
        }

        $stmtGetConsultas->close();
    } else {
        echo "Usuário não encontrado.";
    }

    $stmtGetUser->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar_consulta'])) {
    $consultaId = $_POST['consulta_id'];
    $novaData = $_POST['nova_data'];
    $novoHorario = $_POST['novo_horario'];

    $sqlUpdateConsulta = "UPDATE consultas SET data_consulta = ?, horario = ? WHERE id = ?";
    $stmtUpdateConsulta = $conn->prepare($sqlUpdateConsulta);
    $stmtUpdateConsulta->bind_param("ssi", $novaData, $novoHorario, $consultaId);

    
    $stmtUpdateConsulta->execute();

    
    $stmtUpdateConsulta->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Consultas</title>
    <link href="style/style.css" rel="stylesheet">
    <style>
        body {
            background: url(images/bgimagem.jpg);
        }
    </style>
</head>
<body>

<div class="caixa1">
    <h1>Editar Consultas do Usuário:</h1>

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

    <?php if (isset($consultas)): ?>
        <br><table class="tabela-usuario">
            <tr>
                <th>ID Consulta</th>
                <th>Data da Consulta</th>
                <th>Horário</th>
                <th>Alterar</th>
            </tr>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?php echo $consulta['id']; ?></td>
                    <td><?php echo $consulta['data_consulta']; ?></td>
                    <td><?php echo $consulta['horario']; ?></td>
                    <td>
                        
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="consulta_id" value="<?php echo $consulta['id']; ?>">
                            <label for="nova_data">Nova Data:</label><br>
                            <input type="date" name="nova_data" required>
                            <br><label for="novo_horario">Novo Horário:</label><br>
                            <input type="time" name="novo_horario" required>
                            <input type="submit" name="alterar_consulta" value="Alterar">
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



