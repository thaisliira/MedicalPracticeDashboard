<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: perfil_utilizador.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, data_consulta, horario FROM consultas WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta SQL: " . $conn->error);
}

$consultas = [];

while ($row = $result->fetch_assoc()) {
    $consultas[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Minhas Consultas</title>
    <link href="style/style.css" rel="stylesheet">
    <style>
        body {
            background: url(images/bgimagem.jpg);
        }
    </style>
</head>
<body>

<div class="caixa1">
    <h1>Alterar minhas consultas: </h1>

    <?php if (!empty($consultas)): ?>
        <table class="tabela-usuario">
            <tr>
                <th>ID Consulta</th>
                <th>Data da Consulta</th>
                <th>Horário</th>
                <th>Alterar</th>
            </tr>
            <?php foreach ($consultas as $consulta): ?>
                <?php
                $dataHoraConsulta = strtotime($consulta['data_consulta'] . ' ' . $consulta['horario']);
                $agora = time();
                $diferencaEmSegundos = $dataHoraConsulta - $agora;
                $diferencaEmHoras = $diferencaEmSegundos / 3600;

                if ($diferencaEmHoras > 72):
                ?>
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
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhuma consulta encontrada para este usuário.</p>
    <?php endif; ?>

    <p>Clique <a href="perfil_utilizador.php"><b>aqui</b></a> para voltar.</p>
</div>
</body>
</html>
