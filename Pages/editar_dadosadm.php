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
    $sqlGetUser = "SELECT user_id, nome, apelido, user_name, password, email FROM usuarios WHERE user_id = ?";
    $stmtGetUser = $conn->prepare($sqlGetUser);
    $stmtGetUser->bind_param("i", $selectedUserId);
    $stmtGetUser->execute();
    $resultGetUser = $stmtGetUser->get_result();

    if ($resultGetUser->num_rows > 0) {
        $row = $resultGetUser->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
    }

    $stmtGetUser->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Dados</title>
    <link href="style/style.css" rel="stylesheet">
    <style>
        body {
            background: url(images/bgimagem.jpg);
        }

        .caixa1 {
            margin: 0 auto; 
        }

        .tabela-usuario {
            width: 100%;
            margin-top: 20px;
        }

    </style>
</head>
<body>

<div class="caixa1">
    <h1>Editar dados dos usuários:</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="selected_user_id">Selecione o usuário:</label>
        <select name="selected_user_id" id="selected_user_id">
            <?php
            while ($user = $resultGetUsers->fetch_assoc()) {
                echo "<option value='{$user['user_id']}'" . ($selectedUserId == $user['user_id'] ? " selected" : "") . ">{$user['nome']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Selecionar">
    </form>

    <?php if (isset($row)): ?>
        <form method="post" action="salvar_edicaoadm.php">
            <table class="tabela-usuario">
                <tr>
                    <th>Nome</th>
                    <td><input type="text" name="nome" id="nome" value="<?php echo $row['nome']; ?>" /><br></td>
                </tr>
                <tr>
                    <th>Apelido</th>
                    <td><input type="text" name="apelido" id="apelido" value="<?php echo $row['apelido']; ?>" /><br></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><input type="text" name="user_name" id="user_name" value="<?php echo $row['user_name']; ?>" /><br></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="text" name="email" id="email" value="<?php echo $row['email']; ?>" /><br></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><input type="password" name="password" id="password" value="<?php echo $row['password']; ?>" /><br></td>
                </tr>
                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>" />
                <tr class="centralizar-botao">
                    <td colspan="2"><input type="submit" name="Submit" value="Salvar Alterações" id="botao_form"></td>
                </tr>
            </table>
        </form>
    <?php endif; ?>

    <p>Clique <a href="perfil_administrador.php"><b>aqui</b></a> para voltar.</p>
</div>
</body>
</html
